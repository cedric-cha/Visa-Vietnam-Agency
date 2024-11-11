<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisaType>
 */
class VisaTypeFactory extends Factory
{
    /**
      * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(5),
            'fees' => 0.00,
		  'enabled' => true
        ];
    }
}
 