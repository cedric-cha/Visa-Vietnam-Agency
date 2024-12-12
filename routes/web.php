<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/orders', 'store');
        Route::post('/orders/status', 'status');
        Route::get('/payment-result', 'paymentResult');
        Route::post('/webhook', 'ipn');
    });

Route::get('/check-visa-status', fn () => view('status', ['order' => null]));
