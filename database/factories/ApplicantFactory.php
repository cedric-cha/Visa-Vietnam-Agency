<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'address' => fake()->address(),
            'passport_number' => fake()->uuid(),
            'phone_number' => rand(10, 99).'00'.rand(10, 99).'00'.rand(10, 99),
            'passport_expiration_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'photo' => 'http://thispix.com/wp-content/uploads/2015/06/passport-012.jpg',
            'passport_image' => 'https://tnp.straitstimes.com/sites/default/files/styles/rl680/public/articles/2017/10/27/NP_20171027_MKPASSPORT27_1649459.jpg',
            'password' => null,
            'flight_ticket_image' => 'https://c8.alamy.com/comp/2AFH819/boarding-pass-vector-illustration-airline-ticket-design-with-qr-code-2AFH819.jpg',
            'address_vietnam' => null,
        ];
    }
}
