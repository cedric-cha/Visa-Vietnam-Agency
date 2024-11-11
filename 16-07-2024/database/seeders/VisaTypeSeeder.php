<?php

namespace Database\Seeders;

use App\Models\VisaType;
use Illuminate\Database\Seeder;

class VisaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => '30 days single',
                'fees' => 12.00
            ],
            [
                'description' => '30 days multiple',
                'fees' => 7.00
            ],
            [
                'description' => '90 days single',
                'fees' => 10.00
            ],
            [
                'description' => '90 days multiple',
                'fees' => 4.00
            ],
        ];

        foreach ($data as $datum) {
            VisaType::factory()->create($datum);
        }
    }
}
