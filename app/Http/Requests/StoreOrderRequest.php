<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\OrderServiceType;
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
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'exists:processing_times,id',
            ],
            'purpose_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'exists:purposes,id',
            ],
            'visa_type_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'exists:visa_types,id',
            ],
            'entry_port_id' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'exists:entry_ports,id',
            ],
            'fast_track_entry_port_id' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_arrival_option'))
                ),
                'nullable',
                'exists:entry_ports,id',
            ],
            'fast_track_exit_port_id' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_departure_option'))
                ),
                'nullable',
                'exists:entry_ports,id',
            ],
            'arrival_date' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'date',
                'after:today',
            ],
            'departure_date' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'date',
                'after:'.$this->input('arrival_date'),
            ],
            'full_name' => ['required', 'string'],
            'country' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'exists:countries,id',
            ],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(Gender::values())],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            'address_vietnam' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
                'string',
            ],
            'phone_number' => ['required', 'string'],
            'passport_number' => ['required', 'string'],
            'passport_expiration_date' => ['required', 'date', new PassportExpiration($this)],
            'photo' => ['required', 'file'],
            'passport_image' => ['required', 'file'],
            'flight_ticket_image' => ['required', 'file'],
            'voucher' => ['sometimes', 'nullable', 'exists:vouchers,code'],
            'time_slot_id' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_arrival_option'))
                ),
                'nullable',
                'exists:time_slots,id',
            ],
            'time_slot_departure_id' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_departure_option'))
                ),
                'nullable',
                'exists:time_slots,id',
            ],
            'service' => ['required', Rule::in(OrderServiceType::values())],
            'fast_track_flight_number' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_arrival_option'))
                ),
                'nullable',
            ],
            'fast_track_flight_number_departure' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_departure_option'))
                ),
                'nullable',
            ],
            'fast_track_time' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_arrival_option'))
                ),
                'nullable',
            ],
            'fast_track_date' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_arrival_option'))
                ),
                'nullable',
                'date',
                'after:today',
            ],
            'fast_track_departure_time' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_departure_option'))
                ),
                'nullable',
            ],
            'fast_track_departure_date' => [
                'sometimes',
                Rule::requiredIf(
                    str_contains($this->input('service'), OrderServiceType::FAST_TRACK->value) &&
                    ! is_null($this->input('fast_track_departure_option'))
                ),
                'nullable',
                'date',
                'after:today',
            ],
            'fast_track_arrival_option' => ['sometimes', 'nullable'],
            'fast_track_departure_option' => ['sometimes', 'nullable'],
            'dial_code' => 'required',
            'last_visits' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
            ],
            'attached_images' => [
                'sometimes',
                Rule::requiredIf(str_contains($this->input('service'), OrderServiceType::EVISA->value)),
                'nullable',
            ],
            'feedback' => ['sometimes', 'nullable', 'exists:feedback,id'],
        ];
    }

    public function messages(): array
    {
        return [
            //
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->errorResponse(['message' => $validator->errors()], 422)
        );
    }
}
