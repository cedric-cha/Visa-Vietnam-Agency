<?php

namespace App\Listeners;

use App\Events\OrderProcessed;
use App\Notifications\OrderProcessedNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
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
                new OrderProcessedNotification(
                    $event->order,
                    url('/check-visa-status?reference=' . $event->order->reference . '&password=' . $event->order->applicant->password)
                )
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
