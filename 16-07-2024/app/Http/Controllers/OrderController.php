<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Requests\CheckOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Services\FileUploadService;
use App\Http\UseCases\PaymentUseCase\PaymentUseCase;
use App\Models\Applicant;
use App\Models\Country;
use App\Models\EntryPort;
use App\Models\Order;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\VisaType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Voucher;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'countries' => Country::all(),
            'genders' => Gender::values(),
            'purposes' => Purpose::all(),
            'processingTime' => ProcessingTime::all(),
            'visaTypes' => VisaType::all(),
            'entryPorts' => EntryPort::all()
                ->groupBy('type')
                ->map(fn ($group) =>  ['type' => $group->first()->type, 'entryPorts' => $group->toArray()])
                ->values()
                ->all()
        ]);
    }

    public function store(StoreOrderRequest $request, FileUploadService $fileUploadService, PaymentUseCase $paymentUseCase): RedirectResponse
    {
        if (!$fileUploadService->handle($request->file('photo'), $photo)) {
            return back()
                ->with('error', "We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.")
                ->withInput($request->validated());
        }

        if (!$fileUploadService->handle($request->file('passport_image'), $passportImage)) {
            return back()
                ->with('error', "We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.")
                ->withInput($request->validated());
        }

        $data = $request->validated();
	  
	  //$voucherId = Voucher::query()
	  //->where('code', $data['voucher'])
	  //->first()
	  // ?->id;
	  
	  $voucher = null;
	  if (isset($data['voucher'])){
		$voucher = Voucher::where('code',$data['voucher'])->first();
		if(!$voucher){
			return back()
			  ->with('error',"Invalid voucher code provided.")
			  ->withInput($request->validated());
		}
	  }
	  
	  
	  

        $order = Order::factory()->create([
            'processing_time_id' => $data['processing_time_id'],
            'purpose_id' => $data['purpose_id'],
            'visa_type_id' => $data['visa_type_id'],
            'entry_port_id' => $data['entry_port_id'],
            'arrival_date' => $data['arrival_date'],
		  'voucher_id' => $voucher ? $voucher->id : null,
        ]);

        if (!$order) {
            return back()
                ->with('error', "We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.")
                ->withInput($request->validated());
        }

        $applicant = Applicant::factory()->create([
            'order_id' => $order->id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'passport_number' => $data['passport_number'],
            'passport_expiration_date' => $data['passport_expiration_date'],
            'country' => $data['country'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'photo' => $photo,
            'passport_image' => $passportImage
        ]);

        if (!$applicant) {
            $order->delete();

            return back()
                ->with('error', "We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.")
                ->withInput($request->validated());
        }

        return $paymentUseCase->redirectToPaymentUrl($order);
    }

    public function status(CheckOrderStatusRequest $request): RedirectResponse|View
    {
        $data = $request->validated();

        $order = Order::query()
            ->where('reference', $data['reference'])
            ->first();

        if ($order->applicant->password !== $data['password']) {
            return back()
                ->with('error', "The password you entered is invalid. Please check and try again.")
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
                ->with('error', "We apologize, but there was an error processing your order. Please try again later or contact customer support for assistance.");
        }

        return $paymentUseCase->getPaymentResult($result);
    }

    public function ipn(Request $request, PaymentUseCase $paymentUseCase): JsonResponse
    {
        Log::info('IPN Request Received: ', ['request' => $request->all()]);

        $result = $request->input("result");
        $checkSum = $request->input("checksum");

        $paymentUseCase->readResult($result, $checkSum);

        return response()->json(['success' => true]);
    }
}
