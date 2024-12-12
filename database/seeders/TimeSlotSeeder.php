<?php

namespace Database\Seeders;

use App\Enums\TimeSlotType;
use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Daytime Arrival',
                'start_time' => '7 AM',
                'end_time' => '7 PM',
                'type' => TimeSlotType::ARRIVAL->value,
                'fees' => 10.00,
            ],
            [
                'name' => 'Night Arrival',
                'start_time' => '7 PM',
                'end_time' => '7 AM',
                'type' => TimeSlotType::ARRIVAL->value,
                'fees' => 14.00,
            ],
            [
                'name' => 'Daytime Departure',
                'start_time' => '7 AM',
                'end_time' => '7 PM',
                'type' => TimeSlotType::DEPARTURE->value,
                'fees' => 50.00,
            ],
            [
                'name' => 'Night Departure',
                'start_time' => '7 PM',
                'end_time' => '7 AM',
                'type' => TimeSlotType::DEPARTURE->value,
                'fees' => 74.00,
            ],
        ];

        foreach ($data as $datum) {
            TimeSlot::factory()->create($datum);
        }
    }
}
