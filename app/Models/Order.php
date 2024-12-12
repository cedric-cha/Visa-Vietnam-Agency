<?php

namespace App\Models;

use Eliseekn\LaravelMetrics\HasMetrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory, HasMetrics;

    protected $with = [
        'processingTime',
        'purpose',
        'visaType',
        'entryPort',
        'applicant',
        'voucher',
        'timeSlot',
        'fastTrackEntryPort',
    ];

    protected $fillable = [
        'processing_time_id',
        'purpose_id',
        'visa_type_id',
        'entry_port_id',
        'voucher_id',
        'total_fees',
        'total_fees_with_discount',
        'arrival_date',
        'departure_date',
        'reference',
        'status',
        'visa_pdf',
        'time_slot_id',
        'fast_track_entry_port_id',
        'fast_track_date',
        'service',
    ];

    public function applicant(): HasOne
    {
        return $this->hasOne(Applicant::class);
    }

    public function purpose(): BelongsTo
    {
        return $this->belongsTo(Purpose::class);
    }

    public function visaType(): BelongsTo
    {
        return $this->belongsTo(VisaType::class);
    }

    public function entryPort(): BelongsTo
    {
        return $this->belongsTo(EntryPort::class);
    }

    public function processingTime(): BelongsTo
    {
        return $this->belongsTo(ProcessingTime::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function fastTrackEntryPort(): BelongsTo
    {
        return $this->belongsTo(EntryPort::class, 'fast_track_entry_port_id');
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
