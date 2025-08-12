<?php

namespace App\Listeners;

use App\Events\OrderTransactionSucceeded;
use App\Models\User;
use App\Notifications\OrderPlacedAdminNotification;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\ProcessOrderRequestNotification;
use Exception;
use Illuminate\Support\Facades\Notification;

class SendOrderTransactionSucceededNotification
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
                    $event->order, url('/check-visa-status?reference='.$event->order->reference.'&password='.$event->order->applicant->password)
                )
            );
        } catch (Exception $e) {
            report($e);
        }

        try {
            Notification::send(User::all(), new OrderPlacedAdminNotification($event->order, url('/admin/login')));
        } catch (Exception $e) {
            report($e);
        }

        try {
            Notification::route('mail', config('mail.provider.address'))->notify(
                new ProcessOrderRequestNotification($event->order)
            );
        } catch (Exception $e) {
            report($e);
        }
    }
}
