<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(OrderController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/orders', 'store');
        Route::post('/orders/status', 'status');
        Route::get('/payment-result', 'paymentResult');
        Route::post('/webhook', 'ipn');
    });

Route::get('/check-visa-status', fn () => view('status', ['order' => null]));
