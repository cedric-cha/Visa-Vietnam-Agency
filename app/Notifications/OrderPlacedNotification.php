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
        private $order,
        private string $url,
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
            ->cc('contact@evisa-vietnam-online.com')
            ->line('Your order has been placed successfully.')
            ->line('Applicant : ' . $this->order->applicant->full_name)
            ->line('Purpose : ' . $this->order->purpose->description)
            ->line('Visa Type : ' . $this->order->visaType->description)
            ->line('Entry Port : ' . $this->order->entryPort->name . ' (' . $this->order->entryPort->type . ')')
            ->line('Processing Time : ' . $this->order->processingTime->description)
            ->line('Arrival Date : ' . Carbon::parse($this->order->arrival_date)->format('M d Y'))
            ->line('Departure Date : ' . Carbon::parse($this->order->departure_date)->format('M d Y'))
            ->line('Total Fees : $' . number_format($this->order->total_fees_with_discount ?? $this->order->total_fees, 2))
            ->line('-----')
            ->line('Reference : ' . $this->order->reference)
            ->line('Password : ' . $this->order->applicant->password)
            ->action('Check my order status', $this->url);
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
