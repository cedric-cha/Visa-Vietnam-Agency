<?php

namespace App\Http\UseCases;

use App\Http\Services\FileUploadService;
use App\Http\UseCases\PaymentUseCase\PaymentUseCase;
use App\Models\Applicant;
use App\Models\Order;
use App\Models\Voucher;
use Barryvdh\DomPDF\Facade\Pdf;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class StoreOrderUseCase
{
    use MakeApiResponse;

    public function __construct(
        private readonly PaymentUseCase $paymentUseCase,
        private readonly FileUploadService $fileUploadService
    ) {
    }

    public function handle(array $data, UploadedFile $photoFile, UploadedFile $passportImageFile, UploadedFile $flightTicketImageFile): JsonResponse
    {
        if (! $this->fileUploadService->handle($photoFile, $photo)) {
            logger('Failed to upload photo file');

            return $this->errorResponse('We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.');
        }

        if (! $this->fileUploadService->handle($passportImageFile, $passportImage)) {
            logger('Failed to upload passport image file');

            return $this->errorResponse('We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.');
        }

        if (! $this->fileUploadService->handle($flightTicketImageFile, $flightTicketImage)) {
            logger('Failed to upload flight ticket image file');

            return $this->errorResponse('We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.');
        }

        $order = $this->storeOrder($data);

        $this->storeApplicant($order, $data, $photo, $passportImage, $flightTicketImage);

        Pdf::loadView('pdf', ['order' => $order])
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save($order->reference.'.pdf', 'public');

        return $this->paymentUseCase->redirectToPaymentUrl($order);
    }

    protected function storeApplicant(Order $order, array $data, string $photo, string $passportImage, string $flightTicketImage): void
    {
        try {
            Applicant::factory()->create([
                'order_id' => $order->id,
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'passport_number' => $data['passport_number'],
                'passport_expiration_date' => $data['passport_expiration_date'],
                'country' => $data['country'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'photo' => $photo,
                'passport_image' => $passportImage,
                'flight_ticket_image' => $flightTicketImage,
            ]);
        } catch (Exception $e) {
            report($e);

            $order->delete();

            throw new HttpResponseException(
                $this->errorResponse('We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.')
            );
        }
    }

    protected function storeOrder(array $data): Order
    {
        try {
            return Order::factory()->create([
                'processing_time_id' => $data['processing_time_id'],
                'purpose_id' => $data['purpose_id'],
                'visa_type_id' => $data['visa_type_id'],
                'entry_port_id' => $data['entry_port_id'],
                'arrival_date' => $data['arrival_date'],
                'departure_date' => $data['departure_date'],
                'voucher_id' => Voucher::query()
                    ->where('code', $data['voucher'])
                    ->first()
                    ?->id,
                'fast_track_entry_port_id' => $data['fast_track_entry_port_id'],
                'fast_track_date' => $data['fast_track_date'],
                'time_slot_id' => $data['time_slot_id'],
                'service' => $data['service'],
            ]);
        } catch (Exception $e) {
            report($e);

            throw new HttpResponseException(
                $this->errorResponse('We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.')
            );
        }
    }
}
