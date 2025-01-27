<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderProcessedNotification extends Notification implements ShouldQueue
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
            ->subject('Order processed')
            ->cc('contact@evisa-vietnam-online.com')
            ->line('Your order '.$this->order->reference.' has been processed. Please check your email for the attachment containing your e-visa and/or fast track confirmation to download.');

        if (file_exists(storage_path('app/public').'/'.$this->order->visa_pdf)) {
            $message->attach(storage_path('app/public').'/'.$this->order->visa_pdf);
        }

        if (file_exists(storage_path('app/public').'/'.$this->order->fast_track_pdf)) {
            $message->attach(storage_path('app/public').'/'.$this->order->fast_track_pdf);
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
