<?php

namespace App\Models;

use Eliseekn\LaravelMetrics\HasMetrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    use HasFactory, HasMetrics;

    protected $fillable = [
        'full_name',
        'order_id',
        'country',
        'date_of_birth',
        'gender',
        'email',
        'address',
        'phone_number',
        'passport_number',
        'passport_expiration_date',
        'photo',
        'passport_image',
        'password',
        'flight_ticket_image',
        'address_vietnam',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
