<?php

namespace App\Observers;

use App\Models\Voucher;
use Illuminate\Support\Str;

class VoucherObserver
{
    public function created(Voucher $voucher): void
    {
        $voucher->update(['code' => Str::password(length: 8, symbols: false)]);
    }
}
