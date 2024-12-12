<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryPort extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'is_fast_track',
    ];

    protected $casts = [
        'is_fast_track' => 'boolean',
    ];
}
