<?php

namespace Database\Seeders;

use App\Enums\OrderServiceType;
use App\Models\Applicant;
use App\Models\EntryPort;
use App\Models\Order;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\TimeSlot;
use App\Models\VisaType;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            if ($i > 0 && $i < 15) {
                $order = Order::factory()->create([
                    'processing_time_id' => ProcessingTime::inRandomOrder()->first()->id,
                    'purpose_id' => Purpose::inRandomOrder()->first()->id,
                    'visa_type_id' => VisaType::inRandomOrder()->first()->id,
                    'entry_port_id' => EntryPort::inRandomOrder()->first()->id,
                    'arrival_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                    'departure_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                ]);
            } elseif ($i > 15 && $i < 30) {
                $order = Order::factory()->create([
                    'fast_track_entry_port_id' => EntryPort::inRandomOrder()->first()->id,
                    'fast_track_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                    'time_slot_id' => TimeSlot::inRandomOrder()->first()->id,
                    'service' => OrderServiceType::FAST_TRACK->value,
                ]);
            } else {
                $order = Order::factory()->create([
                    'processing_time_id' => ProcessingTime::inRandomOrder()->first()->id,
                    'purpose_id' => Purpose::inRandomOrder()->first()->id,
                    'visa_type_id' => VisaType::inRandomOrder()->first()->id,
                    'entry_port_id' => EntryPort::inRandomOrder()->first()->id,
                    'arrival_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                    'departure_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                    'fast_track_entry_port_id' => EntryPort::inRandomOrder()->first()->id,
                    'fast_track_date' => fake()->dateTimeBetween()->format('Y-m-d'),
                    'time_slot_id' => TimeSlot::inRandomOrder()->first()->id,
                    'service' => OrderServiceType::EVISA_FAST_TRACK->value,
                ]);
            }

            Applicant::factory()
                ->for($order)
                ->create();
        }
    }
}
