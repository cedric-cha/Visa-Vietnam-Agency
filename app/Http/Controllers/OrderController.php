<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\TimeSlotType;
use App\Http\Requests\CheckOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\UseCases\PaymentUseCase\PaymentUseCase;
use App\Http\UseCases\StoreOrderUseCase;
use App\Models\Country;
use App\Models\EntryPort;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\TimeSlot;
use App\Models\VisaType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'countries' => Country::all(),
            'genders' => Gender::values(),
            'purposes' => Purpose::all(),
            'processingTime' => ProcessingTime::all(),
            'visaTypes' => VisaType::query()->where('enabled', 1)->get(),
            'entryPorts' => EntryPort::all()
                ->groupBy('type')
                ->map(fn ($group) => ['type' => $group->first()->type, 'entryPorts' => $group->toArray()])
                ->values()
                ->all(),
            'fastTrackEntryPorts' => EntryPort::all()
                ->filter(fn (EntryPort $entryPort) => $entryPort->is_fast_track)
                ->groupBy('type')
                ->map(fn ($group) => ['type' => $group->first()->type, 'entryPorts' => $group->toArray()])
                ->values()
                ->all(),
            'fastTrackExitPorts' => EntryPort::all()
                ->filter(fn (EntryPort $entryPort) => $entryPort->is_fast_track)
                ->groupBy('type')
                ->map(fn ($group) => ['type' => $group->first()->type, 'exitPorts' => $group->toArray()])
                ->values()
                ->all(),
            'timeSlots' => TimeSlot::query()
                ->select('id', 'name', 'start_time', 'end_time')
                ->where('type', TimeSlotType::ARRIVAL->value)
                ->get(),
            'timeSlotsDeparture' => TimeSlot::query()
                ->select('id', 'name', 'start_time', 'end_time')
                ->where('type', TimeSlotType::DEPARTURE->value)
                ->get(),
            'feedbacks' => Feedback::query()->select('id', 'title')->get(),
        ]);
    }

    public function store(StoreOrderRequest $request, StoreOrderUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated(),
            $request->file('photo'),
            $request->file('passport_image'),
            $request->file('flight_ticket_image'),
        );
    }

    public function status(CheckOrderStatusRequest $request): RedirectResponse|View
    {
        $data = $request->validated();

        $order = Order::query()
            ->where('reference', $data['reference'])
            ->first();

        if ($order->applicant->password !== $data['password']) {
            return back()
                ->with('error', 'The password you entered is invalid. Please check and try again.')
                ->withInput($request->validated());
        }

        return view('status', compact('order'));
    }

    public function paymentResult(Request $request, PaymentUseCase $paymentUseCase): RedirectResponse
    {
        $result = $request->query('result');

        if (is_null($result)) {
            return redirect()
                ->to('/')
                ->with('error', 'We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.');
        }

        return $paymentUseCase->getPaymentResult($result);
    }

    public function ipn(Request $request, PaymentUseCase $useCase): JsonResponse
    {
        return $useCase->readPaymentResult($request->only('result', 'checksum'));
    }
}
