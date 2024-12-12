<?php

namespace Database\Factories;

use App\Enums\EntryPortType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EntryPort>
 */
class EntryPortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(EntryPortType::values()),
            'name' => fake()->word(),
            'is_fast_track' => 0,
        ];
    }
}
