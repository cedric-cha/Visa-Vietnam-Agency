<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Notifications\OrderCancelledNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCancelledNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        try {
            Notification::route('mail', $event->order->applicant->email)->notify(
                new OrderCancelledNotification(
                    $event->order->reference,
                    url('/check-visa-status?reference='.$event->order->reference.'&password='.$event->order->applicant->password)
                )
            );
        } catch (Exception $e) {
            report($e);
        }
    }
}
