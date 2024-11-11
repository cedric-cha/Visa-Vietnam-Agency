<?php

namespace Database\Seeders;

use App\Models\ProcessingTime;
use Illuminate\Database\Seeder;

class ProcessingTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => '6 working days',
                'fees' => 10.00
            ],
            [
                'description' => '4 working days',
                'fees' => 25.00
            ],
            [
                'description' => '2 working days',
                'fees' => 5.00
            ],
            [
                'description' => '6 working hours',
                'fees' => 30.00
            ],
            [
                'description' => '4 working hours',
                'fees' => 60.00
            ],
            [
                'description' => '2 working hours',
                'fees' => 45.00
            ],
        ];

        foreach ($data as $datum) {
            ProcessingTime::factory()->create($datum);
        }
    }
}
