<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Seeder;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Tourism',
                'fees' => 5.00
            ],
            [
                'description' => 'Business',
                'fees' => 60.00
            ],
        ];

        foreach ($data as $datum) {
            Purpose::factory()->create($datum);
        }
    }
}
