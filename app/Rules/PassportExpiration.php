<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class PassportExpiration implements ValidationRule
{
    public function __construct(public Request $request)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $departureDate = Carbon::parse($this->request->input('departure_date'));
        $passportExpiry = Carbon::parse($value);

        if ($passportExpiry->lt($departureDate) || $passportExpiry->diffInMonths($departureDate) < 6) {
            $fail('The passport expiration date must be at least 6 months after the departure date.');
        }
    }
}
