<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'order_id' => Order::factory(),
            'country' => 1,
            'date_of_birth' => fake()->dateTimeBetween()->format('Y-m-d'),
            'gender' => 'male',
            'email' => fake()->safeEmail(),
            'address' => null,
            'passport_number' => rand(10, 99) . '00' . rand(10, 99) . '00' . rand(10, 99),
            'phone_number' => null,
            'passport_expiration_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'photo' => 'http://thispix.com/wp-content/uploads/2015/06/passport-012.jpg',
            'passport_image' => 'https://tnp.straitstimes.com/sites/default/files/styles/rl680/public/articles/2017/10/27/NP_20171027_MKPASSPORT27_1649459.jpg',
            'password' => null,
        ];
    }
}
