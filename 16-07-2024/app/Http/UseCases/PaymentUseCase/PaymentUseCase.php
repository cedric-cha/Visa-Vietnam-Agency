<?php

namespace App\Http\UseCases\PaymentUseCase;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Notifications\OrderPlacedAdminNotification;
use App\Notifications\OrderPlacedNotification;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PaymentUseCase
{
    public function __construct(
        // sandbox
        //private string $endPoint = 'https://sand-payment.9pay.vn',
        //private string $secretKey = 'AhBwACK1elBGwiOspkBHyfUCAHyAAvyg2CQ',
        //private string $keyChecksum = '7SDMRDW0PyaSt2urwztUjPGQGv78CkML',
        //private string $merchantKey = 'FxWijU',

        // production
        private string $endPoint = 'https://payment.9pay.vn',
        private string $secretKey = 'WWMPSj5dmZoDIAYW4LThFyd14j3cTBnu7JP',
        private string $keyChecksum = '27mZuSJhm8wWWkq9xBJpeng7i96cGybm',
        private string $merchantKey = 'MCZSV5',
    ) {
    }

    protected function sign($message, $key): string
    {
        return hash_hmac('sha256', $message, $key, true);
    }

    protected function base64Decode(string $input): string
    {
        $remainder = strlen($input) % 4;

        if ($remainder) {
            $padLen = 4 - $remainder;
            $input .= str_repeat('=', $padLen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    protected function getStatus(int $status): string
    {
        return match ($status) {
            5 => OrderStatus::TRANSACTION_SUCCESS->value,
            8 => OrderStatus::TRANSACTION_CANCELED->value,
            6 => OrderStatus::TRANSACTION_FAILED->value,
            15 => OrderStatus::TRANSACTION_EXPIRED->value,
            default => OrderStatus::TRANSACTION_IN_PROGRESS->value,
        };
    }

    public function redirectToPaymentUrl(Order $order): RedirectResponse
    {
        $time = time();

        $data = [
            'merchantKey' => $this->merchantKey,
            'invoice_no' => $order->reference,
            'amount' => ($order->voucher && $order->voucher->valid) ? $order->total_fees_with_discount : $order->total_fees,
            'description' => 'e-Visa Vietnam Online Order',
            'return_url' => url('/payment-result'),
            'time' => $time,
            'lang' => 'en',
            'currency' => 'USD'
        ];

        $message = MessageBuilder::instance()
            ->with($time, $this->endPoint . '/payments/create', 'POST')
            ->withParams($data)
            ->build();

        $queries = [
            'baseEncode' => base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE)),
            'signature' => base64_encode($this->sign($message, $this->secretKey)),
        ];

        return redirect()->away($this->endPoint .  '/portal?' . http_build_query($queries));
    }

    public function getPaymentResult(string $result): RedirectResponse
    {
        $result = $this->base64Decode($result);
        $result = json_decode($result, true);

        if ($this->getStatus($result['status']) === OrderStatus::TRANSACTION_SUCCESS->value) {
            return redirect('/')->with('success', "Thank you for your order! We've received your request and will process it promptly. An email with your order details has been sent to you. If you have any questions, feel free to contact us.");
        }

        return redirect('/')->with('warning',  'Transaction status: ' . $this->getStatus($result['status']));
    }

    public function readResult(string $message = null, string $sum = null): void
    {
        if (!isset($message) || !isset($sum)) {
            Log::info("Check result failed 1");
            return;
        }

        if ($this->verifyResult($sum, $message)) {
            $result = $this->convertArray(base64_decode($message));

            Log::info("Check result success",  ['rs' => $result]);

            $order = Order::query()
                ->where('reference', $result['invoice_no'])
                ->first();

            $order->update(['status' => $this->getStatus($result['status'])]);

            if (($this->getStatus($result['status']) === OrderStatus::TRANSACTION_SUCCESS->value)) {
                try {
                    Notification::route('mail', $order->applicant->email)->notify(
                        new OrderPlacedNotification(
                            $order->reference,
                            $order->applicant->password,
                            url('/check-visa-status?reference=' . $order->reference . '&password=' . $order->applicant->password)
                        )
                    );
                } catch (Exception $e) {
                    Log::error('Error processing order: ' . $e->getMessage());
                }

                $users = User::all();

                foreach ($users as $user) {
                    try {
                        $user->notify(new OrderPlacedAdminNotification($order, url('/admin/login')));
                    } catch (Exception $e) {
                        Log::error('Error processing order: ' . $e->getMessage());
                    }
                }
            }
        } else {
            Log::info("Check result failed 2");
        }
    }
    protected function verifyResult(string $signature, string $result): string
    {
        $hashChecksum = strtoupper(hash('sha256', $result . $this->keyChecksum));
        return !strcmp($hashChecksum, $signature);
    }

    protected function convertArray($data): array
    {
        if (!$data) {
            return [];
        }
        $tmp = json_decode(json_encode($data, true), true);
        if (!is_array($tmp)) {
            $tmp = json_decode($tmp, true);
        }
        return $tmp;
    }
}
