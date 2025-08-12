<?php

namespace App\Providers;

use App\Events\OrderCancelled;
use App\Events\OrderProcessed;
use App\Events\OrderTransactionSucceeded;
use App\Listeners\GenerateInvoice;
use App\Listeners\SendOrderCancelledNotification;
use App\Listeners\SendOrderProcessedNotification;
use App\Listeners\SendOrderTransactionSucceededNotification;
use App\Models\Applicant;
use App\Models\Order;
use App\Models\Voucher;
use App\Observers\ApplicantObserver;
use App\Observers\OrderObserver;
use App\Observers\VoucherObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OrderProcessed::class => [
            SendOrderProcessedNotification::class,
        ],

        OrderCancelled::class => [
            SendOrderCancelledNotification::class,
        ],

        OrderTransactionSucceeded::class => [
            GenerateInvoice::class,
            SendOrderTransactionSucceededNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
        Applicant::observe(ApplicantObserver::class);
        Voucher::observe(VoucherObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
