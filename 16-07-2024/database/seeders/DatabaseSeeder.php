<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@mail.com',
            'password' => 'password'
        ]);

        $this->call([
            CountrySeeder::class,
            EntryPortSeeder::class,
            ProcessingTimeSeeder::class,
            VisaTypeSeeder::class,
            PurposeSeeder::class
        ]);
    }
}
