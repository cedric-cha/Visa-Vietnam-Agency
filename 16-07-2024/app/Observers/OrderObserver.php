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
        $order->update([
            'total_fees' => $order->purpose->fees + $order->processingTime->fees + $order->visaType->fees,
            'reference' => 'E_VISA_' . str_pad(10984 + $order->id, 10, '0', STR_PAD_LEFT) . 'T' . time(),
        ]);

        if ($order->voucher && $order->voucher->valid) {
            $order->update([
                'total_fees_with_discount' => $order->total_fees - (($order->voucher->discount * $order->total_fees) / 100)
            ]);
        }
    }

    public function updated(Order $order): void
    {
        if ($order->status === OrderStatus::PROCESSED->value) {
            OrderProcessed::dispatch($order);
        }

        if ($order->status === OrderStatus::CANCELLED->value) {
            OrderCancelled::dispatch($order);
        }
    }
}
