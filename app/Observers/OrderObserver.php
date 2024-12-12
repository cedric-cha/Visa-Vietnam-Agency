<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Events\OrderCancelled;
use App\Events\OrderProcessed;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order): void
    {
        $orderId = 10984 + $order->id;

        $order->update([
            'total_fees' => ($order->purpose?->fees ?? 0) +
                ($order->processingTime?->fees ?? 0) +
                ($order->visaType?->fees ?? 0) +
                ($order->timeSlot?->fees ?? 0),
            'reference' => 'E_VISA_'.str_pad("$orderId", 10, '0', STR_PAD_LEFT).'T'.time(),
        ]);

        if ($order->voucher && $order->voucher->valid) {
            $order->update([
                'total_fees_with_discount' => $order->total_fees - (($order->voucher->discount * $order->total_fees) / 100),
            ]);
        }
    }

    public function updated(Order $order): void
    {
        if ($order->status === OrderStatus::PROCESSED->value) {
            event(new OrderProcessed($order));
        }

        if ($order->status === OrderStatus::CANCELLED->value) {
            event(new OrderCancelled($order));
        }
    }
}
