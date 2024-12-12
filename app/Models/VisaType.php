<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'fees',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
