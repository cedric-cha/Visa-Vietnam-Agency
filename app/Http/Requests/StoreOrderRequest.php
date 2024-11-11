<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Rules\PassportExpiration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'processing_time_id' => 'required|exists:processing_times,id',
            'purpose_id' => 'required|exists:purposes,id',
            'visa_type_id' => 'required|exists:visa_types,id',
            'entry_port_id' => 'required|exists:entry_ports,id',
            'arrival_date' => 'required|date|after:today',
            'departure_date' => 'required|date|after:' . $this->input('arrival_date'),
            'full_name' => 'required|string',
            'country' => 'required|exists:countries,id',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::in(Gender::values())],
            'email' => 'required|email',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'passport_number' => 'required|string',
            'passport_expiration_date' => ['required', 'date', new PassportExpiration($this)],
            'photo' => 'required|file',
            'passport_image' => 'required|file',
            'voucher' => 'sometimes|nullable|exists:vouchers,code'
        ];
    }
}
