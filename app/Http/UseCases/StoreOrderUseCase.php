<?php

namespace App\Http\UseCases;

use App\Http\Services\FileUploadService;
use App\Http\UseCases\PaymentUseCase\PaymentUseCase;
use App\Models\Applicant;
use App\Models\Country;
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
    ) {}

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

        if (str_contains($data['service'], 'evisa')) {
            Pdf::loadView('pdf.evisa', ['order' => $order])
                ->setWarnings(false)
                ->save($order->reference.'_E_VISA_SERVICE.pdf', 'public');
        }

        if (str_contains($data['service'], 'fast_track')) {
            Pdf::loadView('pdf.fast-track', [
                'order' => $order,
                'arrival' => isset($data['fast_track_arrival_option']),
                'departure' => isset($data['fast_track_departure_option']),
            ])
                ->setWarnings(false)
                ->save($order->reference.'_FAST_TRACK_SERVICE.pdf', 'public');
        }

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
                'address_vietnam' => $data['address_vietnam'] ?? null,
                'phone_number' => $data['phone_number'],
                'passport_number' => $data['passport_number'],
                'passport_expiration_date' => $data['passport_expiration_date'],
                'country' => Country::query()
                    ->where('id', $data['country'])
                    ->first()
                    ?->name,
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
        if (! isset($data['fast_track_arrival_option'])) {
            $data['fast_track_entry_port_id'] = null;
            $data['fast_track_date'] = null;
            $data['fast_track_time'] = null;
            $data['fast_track_flight_number'] = null;
            $data['time_slot_id'] = null;
        }

        if (! isset($data['fast_track_departure_option'])) {
            $data['fast_track_exit_port_id'] = null;
            $data['fast_track_departure_date'] = null;
            $data['fast_track_departure_time'] = null;
            $data['fast_track_flight_number_departure'] = null;
            $data['time_slot_departure_id'] = null;
        }

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
                'fast_track_exit_port_id' => $data['fast_track_exit_port_id'],
                'fast_track_date' => $data['fast_track_date'],
                'fast_track_time' => $data['fast_track_time'],
                'fast_track_departure_date' => $data['fast_track_departure_date'],
                'fast_track_departure_time' => $data['fast_track_departure_time'],
                'fast_track_flight_number' => $data['fast_track_flight_number'],
                'fast_track_flight_number_departure' => $data['fast_track_flight_number_departure'],
                'time_slot_id' => $data['time_slot_id'],
                'time_slot_departure_id' => $data['time_slot_departure_id'],
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
