<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $order,
        public string $url,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order placed')
            ->greeting('Xin Chào')
            ->cc('contact@visa-vietnam-agency.com')
            ->line('Your order has been placed successfully.')
            ->line('Applicant : '.$this->order->applicant->full_name)
            ->line('Purpose : '.$this->order->purpose->description ?? 'N/A')
            ->line('Visa Type : '.$this->order->visaType->description ?? 'N/A')
            ->line('Entry Port : '.$this->getEntryPort())
            ->line('Processing Time : '.$this->order->processingTime->description ?? 'N/A')
            ->line('Arrival Date : '.$this->getArrivalDate())
            ->line('Departure Date : '.$this->getDepartureDate())
            ->line('Fast track entry port : '.$this->getFastTrackEntryPort())
            ->line('Fast track arrival date : '.$this->getFastTrackDate())
            ->line('Fast track time slot : '.$this->getTimeSlot())
            ->line('Fast track arrival time : '.$this->order->fast_track_time ?? 'N/A')
            ->line('Arrival flight number : '.$this->order->fast_track_flight_number ?? 'N/A')
            ->line('Fast track exit port : '.$this->getFastTrackExitPort())
            ->line('Fast track departure date : '.$this->getFastTrackDepartureDate())
            ->line('Fast track time slot : '.$this->getTimeSlotDeparture())
            ->line('Fast track departure time : '.$this->order->fast_track_departure_time ?? 'N/A')
            ->line('Departure flight number : '.$this->order->fast_track_flight_number_departure ?? 'N/A')
            ->line('----------')
            ->line('Total Fees : $'.number_format($this->order->total_fees_with_discount ?? $this->order->total_fees, 2))
            ->line('----------')
            ->line('Reference : '.$this->order->reference)
            ->line('Password : '.$this->order->applicant->password)
            ->action('Check my order status', $this->url);
    }

    protected function getEntryPort(): string
    {
        if (is_null($this->order->entryPort)) {
            return 'N/A';
        }

        return '('.$this->order->entryPort->type.') '.$this->order->entryPort->name;
    }

    protected function getFastTrackEntryPort(): string
    {
        if (is_null($this->order->fastTrackEntryPort)) {
            return 'N/A';
        }

        return $this->order->fastTrackEntryPort->name.' ('.$this->order->fastTrackEntryPort->type.')';
    }

    protected function getArrivalDate(): string
    {
        if (is_null($this->order->arrival_date)) {
            return 'N/A';
        }

        return Carbon::parse($this->order->arrival_date)->format('d M Y');
    }

    protected function getFastTrackDate(): string
    {
        if (is_null($this->order->fast_track_date)) {
            return 'N/A';
        }

        return Carbon::parse($this->order->fast_track_date)->format('d M Y');
    }

    protected function getDepartureDate(): string
    {
        if (is_null($this->order->departure_date)) {
            return 'N/A';
        }

        return Carbon::parse($this->order->departure_date)->format('d M Y');
    }

    protected function getTimeSlot(): string
    {
        if (is_null($this->order->timeSlot)) {
            return 'N/A';
        }

        return $this->order->timeSlot->name.'('.$this->order->timeSlot->start_time.' to '.$this->order->timeSlot->end_time.')';
    }

    protected function getFastTrackExitPort(): string
    {
        if (is_null($this->order->fastTrackExitPort)) {
            return 'N/A';
        }

        return $this->order->fastTrackExitPort->name.' ('.$this->order->fastTrackExitPort->type.')';
    }

    protected function getFastTrackDepartureDate(): string
    {
        if (is_null($this->order->fast_track_departure_date)) {
            return 'N/A';
        }

        return Carbon::parse($this->order->fast_track_departure_date)->format('d M Y');
    }

    protected function getTimeSlotDeparture(): string
    {
        if (is_null($this->order->timeSlotDeparture)) {
            return 'N/A';
        }

        return $this->order->timeSlotDeparture->name.'('.$this->order->timeSlotDeparture->start_time.' to '.$this->order->timeSlotDeparture->end_time.')';
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
