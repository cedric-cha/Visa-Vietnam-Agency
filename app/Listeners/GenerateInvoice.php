<?php

namespace App\Listeners;

use App\Events\OrderTransactionSucceeded;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateInvoice
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
        $filename = $event->order->reference.'_INVOICE.pdf';

        Pdf::loadView('pdf.invoice', ['order' => $event->order])
            ->setWarnings(false)
            ->save($filename, 'public');

        Order::query()
            ->where('id', $event->order->id)
            ->update(['invoice' => $filename]);
    }
}
