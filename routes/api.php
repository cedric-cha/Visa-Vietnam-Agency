<?php

use App\Http\Controllers\VoucherController;
use App\Models\EntryPort;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\VisaType;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/processing-time/{id}', function (int $id) {
    return response()->json(ProcessingTime::query()->find($id));
})->whereNumber('id');

Route::get('/purposes/{id}', function (int $id) {
    return response()->json(Purpose::query()->find($id));
})->whereNumber('id');

Route::get('/visa-types/{id}', function (int $id) {
    return response()->json(VisaType::query()->find($id));
})->whereNumber('id');

Route::get('/entry-ports/{id}', function (int $id) {
    return response()->json(EntryPort::query()->find($id));
})->whereNumber('id');

Route::get('/voucher/{code}', VoucherController::class)->whereAlphaNumeric('code');