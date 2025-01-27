<?php

namespace App\Listeners;

use App\Events\OrderProcessed;
use App\Notifications\OrderProcessedNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderProcessedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(OrderProcessed $event): void
    {
        try {
            Notification::route('mail', $event->order->applicant->email)->notify(
                new OrderProcessedNotification($event->order)
            );
        } catch (Exception $e) {
            report($e);
        }
    }
}
