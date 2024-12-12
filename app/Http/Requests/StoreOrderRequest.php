<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Rules\PassportExpiration;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    use MakeApiResponse;

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
            'processing_time_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'exists:processing_times,id',
            ],
            'purpose_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'exists:purposes,id',
            ],
            'visa_type_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'exists:visa_types,id',
            ],
            'entry_port_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'exists:entry_ports,id',
            ],
            'fast_track_entry_port_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'fast_track')),
                'nullable',
                'exists:entry_ports,id',
            ],
            'arrival_date' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'date',
                'after:today',
            ],
            'departure_date' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'evisa')),
                'nullable',
                'date',
                'after:'.$this->input('arrival_date'),
            ],
            'fast_track_date' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'fast_track')),
                'nullable',
                'date',
                'after:today',
            ],
            'full_name' => ['required', 'string'],
            'country' => ['required', 'exists:countries,id'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(Gender::values())],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'passport_number' => ['required', 'string'],
            'passport_expiration_date' => ['required', 'date', new PassportExpiration($this)],
            'photo' => ['required', 'file'],
            'passport_image' => ['required', 'file'],
            'flight_ticket_image' => ['required', 'file'],
            'voucher' => ['sometimes', 'nullable', 'exists:vouchers,code'],
            'time_slot_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), 'fast_track')),
                'nullable',
                'exists:time_slots,id',
            ],
            'service' => [
                'required',
                Rule::in([
                    'evisa',
                    'fast_track',
                    'evisa_fast_track',
                ]),
            ],
            //'captcha' => ['required', 'captcha'],
        ];
    }

    public function messages(): array
    {
        return [
            //'captcha.captcha' => 'Captcha is not correct.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse(['message' => $validator->errors()], 422)
        );
    }
}
