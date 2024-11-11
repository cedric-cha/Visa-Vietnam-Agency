<?php

namespace App\Observers;

use App\Models\Applicant;
use Illuminate\Support\Str;

class ApplicantObserver
{
    public function created(Applicant $applicant): void
    {
        $applicant->update(['password' => Str::password(length: 10, symbols: false)]);
    }
}
