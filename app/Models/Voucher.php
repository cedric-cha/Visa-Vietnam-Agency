<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'valid',
        'discount'
    ];

    protected $casts = [
        'valid' => 'boolean'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
