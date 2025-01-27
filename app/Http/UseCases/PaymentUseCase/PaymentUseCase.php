<?php

namespace App\Http\UseCases\PaymentUseCase;

use App\Enums\OrderStatus;
use App\Events\OrderTransactionSucceeded;
use App\Models\Order;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PaymentUseCase
{
    use MakeApiResponse;

    public function __construct() {}

    protected function getEndPoint(): string
    {
        if (config('9pay.sandbox') === true) {
            return config('9pay.endpoint_sandbox');
        }

        return config('9pay.endpoint');
    }

    protected function getSecretKey(): string
    {
        if (config('9pay.sandbox') === true) {
            return config('9pay.merchant_secret_key_sandbox');
        }

        return config('9pay.merchant_secret_key');
    }

    protected function getKeyChecksum(): string
    {
        if (config('9pay.sandbox') === true) {
            return config('9pay.merchant_checksum_key_sandbox');
        }

        return config('9pay.merchant_checksum_key');
    }

    protected function getMerchantKey(): string
    {
        if (config('9pay.sandbox') === true) {
            return config('9pay.merchant_key_sandbox');
        }

        return config('9pay.merchant_key');
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

    public function redirectToPaymentUrl(Order $order): JsonResponse
    {
        $time = time();

        $data = [
            'merchantKey' => $this->getMerchantKey(),
            'invoice_no' => $order->reference,
            'amount' => ($order->voucher && $order->voucher->valid) ? $order->total_fees_with_discount : $order->total_fees,
            'description' => 'e-Visa Vietnam Online Order',
            'return_url' => url('/payment-result'),
            'time' => $time,
            'lang' => 'en',
            'currency' => 'USD',
        ];

        $message = MessageBuilder::instance()
            ->with($time, $this->getEndPoint().'/payments/create', 'POST')
            ->withParams($data)
            ->build();

        $queries = [
            'baseEncode' => base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE)),
            'signature' => base64_encode($this->sign($message, $this->getSecretKey())),
        ];

        return $this->successResponse($this->getEndPoint().'/portal?'.http_build_query($queries));
    }

    public function getPaymentResult(string $result): RedirectResponse
    {
        $result = $this->base64Decode($result);
        $result = json_decode($result, true);

        if ($this->getStatus($result['status']) === OrderStatus::TRANSACTION_SUCCESS->value) {
            return redirect('/')->with('success', "Thank you for your order! We've received your request and will process it promptly. An email with your order details has been sent to you. If you have any questions, feel free to contact us.");
        }

        return redirect('/')->with('warning', 'Transaction status: '.$this->getStatus($result['status']));
    }

    public function readPaymentResult(array $data): JsonResponse
    {
        if (! isset($data['result']) || ! isset($data['checksum'])) {
            logger('Failed to read result');

            return response()->json(['success' => false]);
        }

        if (! $this->verifyResult($data['checksum'], $data['result'])) {
            logger('Failed verify result');

            return response()->json(['success' => false]);
        }

        $result = $this->convertArray(base64_decode($data['result']));

        $order = Order::query()
            ->where('reference', $result['invoice_no'])
            ->first();

        $order->update(['status' => $this->getStatus($result['status'])]);

        if ($this->getStatus($result['status']) === OrderStatus::TRANSACTION_SUCCESS->value) {
            event(new OrderTransactionSucceeded($order));

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    protected function verifyResult(string $signature, string $result): bool
    {
        $hashChecksum = strtoupper(hash('sha256', $result.$this->getKeyChecksum()));

        return ! strcmp($hashChecksum, $signature);
    }

    protected function convertArray($data): array
    {
        if (! $data) {
            return [];
        }

        $tmp = json_decode(json_encode($data), true);

        if (! is_array($tmp)) {
            $tmp = json_decode($tmp, true);
        }

        return $tmp;
    }
}
