<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\EntryPort;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\VisaType;
use App\Models\Voucher;
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
            'processing_time_id' => ProcessingTime::factory(),
            'purpose_id' => Purpose::factory(),
            'visa_type_id' => VisaType::factory(),
            'entry_port_id' => EntryPort::factory(),
            'voucher_id' => Voucher::factory(),
            'total_fees' => null,
            'total_fees_with_discount' => null,
            'reference' => null,
            'arrival_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'departure_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'status' => OrderStatus::PENDING->value,
            'visa_pdf' =>  null
        ];
    }
}
