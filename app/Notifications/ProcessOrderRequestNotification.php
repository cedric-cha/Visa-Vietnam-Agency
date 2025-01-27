<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProcessOrderRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $order,
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
        $message = (new MailMessage)
            ->subject('Process order request')
            ->greeting('Xin Chào')
            ->cc('contact@evisa-vietnam-online.com')
            ->line('Find as attachments all informations about the process request.')
            ->attach(storage_path('app/public/'.$this->order->applicant->passport_image))
            ->attach(storage_path('app/public/'.$this->order->applicant->photo))
            ->attach(storage_path('app/public/'.$this->order->applicant->flight_ticket_image));

        if (file_exists(storage_path('app/public/'.$this->order->reference.'_E_VISA_SERVICE.pdf'))) {
            $message->attach(storage_path('app/public/'.$this->order->reference.'_E_VISA_SERVICE.pdf'));
        }

        if (file_exists(storage_path('app/public/'.$this->order->reference.'_FAST_TRACK_SERVICE.pdf'))) {
            $message->attach(storage_path('app/public/'.$this->order->reference.'_FAST_TRACK_SERVICE.pdf'));
        }

        return $message;
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
