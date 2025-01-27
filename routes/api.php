<?php

use App\Http\Controllers\IncrementFeedbackValueController;
use App\Http\Controllers\VoucherController;
use App\Models\EntryPort;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\TimeSlot;
use App\Models\VisaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/time-slots/{id?}', function (Request $request, ?int $id = null) {
    if (! is_null($id)) {
        return response()->json(TimeSlot::query()->find($id));
    }

    return response()->json(
        TimeSlot::query()
            ->where('type', $request->query('type', 'Arrival'))
            ->get()
    );
})->whereNumber('id');

Route::get('/voucher/{code}', VoucherController::class)->whereAlphaNumeric('code');
Route::get('/feedback/{feedback}', IncrementFeedbackValueController::class);
