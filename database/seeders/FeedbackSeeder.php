<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            'Google',
            'Family',
            'Friends',
            'Connections',
            'Travel Agency',
            'Other',
        ];

        foreach ($titles as $title) {
            Feedback::factory()->create([
                'title' => $title,
                'count' => 0,
            ]);
        }
    }
}
