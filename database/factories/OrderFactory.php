<?php

namespace Database\Factories;

use App\Enums\OrderServiceType;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'processing_time_id' => null,
            'purpose_id' => null,
            'visa_type_id' => null,
            'entry_port_id' => null,
            'voucher_id' => null,
            'total_fees' => null,
            'total_fees_with_discount' => null,
            'reference' => null,
            'arrival_date' => null,
            'departure_date' => null,
            'status' => OrderStatus::PENDING->value,
            'visa_pdf' => null,
            'time_slot_id' => null,
            'fast_track_entry_port_id' => null,
            'fast_track_date' => null,
            'service' => OrderServiceType::EVISA->value,
        ];
    }
}
