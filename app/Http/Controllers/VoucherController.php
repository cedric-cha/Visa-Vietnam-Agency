<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

class VoucherController extends Controller
{
    use MakeApiResponse;

    public function __invoke(string $code): JsonResponse
    {
        $voucher = Voucher::query()
            ->where('code', $code)
            ->where('valid', 1)
            ->first();

        return $voucher
            ? $this->successResponse($voucher->discount)
            : $this->errorResponse('Invalid voucher code.', 400);
    }
}
