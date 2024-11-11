<?php

namespace App\Listeners;

use App\Events\OrderTransactionSucceeded;
use App\Models\User;
use App\Notifications\OrderPlacedAdminNotification;
use App\Notifications\OrderPlacedNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendOrderTransactionSucceededNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(OrderTransactionSucceeded $event): void
    {
        try {
            Notification::route('mail', $event->order->applicant->email)->notify(
                new OrderPlacedNotification(
                    $event->order->reference,
                    $event->order->applicant->password,
                    url('/check-visa-status?reference=' . $event->order->reference . '&password=' . $event->order->applicant->password)
                )
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        try {
            Notification::send(User::all(), new OrderPlacedAdminNotification($event->order, url('/admin/login'))) ;
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
