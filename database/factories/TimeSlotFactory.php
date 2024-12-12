<?php

namespace Database\Factories;

use App\Enums\TimeSlotType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'type' => fake()->randomElement([TimeSlotType::values()]),
            'start_time' => now()->toTimeString(),
            'end_time' => now()->toTimeString(),
            'fees' => 0.00,
        ];
    }
}
