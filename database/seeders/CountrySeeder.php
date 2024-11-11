<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Argentina',
            'Brazil',
            'Canada',
            'Chile',
            'Colombia',
            'Cuba',
            'Honduras',
            'Mexico',
            'Panama',
            'Peru',
            'United States of America',
            'Uruguay',
            'Venezuela',
            'South Africa',
            'Azerbaijan',
            'Brunei',
            'China',
            'Georgia',
            'India',
            'Israel',
            'Japan',
            'Kazakhstan',
            'Mongolia',
            'Myanmar',
            'Papua New Guinea',
            'Philippines',
            'Qatar',
            'Russia',
            'Singapore',
            'South Korea',
            'Timor Leste',
            'United Arab Emirates',
            'Uzbekistan',
            'Andorra',
            'Armenia',
            'Austria',
            'Belarus',
            'Belgium',
            'Bosnia Herzegovina',
            'Bulgaria',
            'Croatia',
            'Cyprus',
            'Czech Republic',
            'Denmark',
            'Estonia',
            'Finland',
            'France',
            'Germany',
            'Greece',
            'Hungary',
            'Iceland',
            'Ireland',
            'Italy',
            'Latvia',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Malta',
            'Moldova',
            'Monaco',
            'Montenegro',
            'Netherlands',
            'North Macedonia',
            'Norway',
            'Poland',
            'Portugal',
            'Romania',
            'San Marino',
            'Serbia',
            'Slovakia',
            'Slovenia',
            'Spain',
            'Sweden',
            'Switzerland',
            'United Kingdom',
            'Australia',
            'Fiji',
            'Marshall Islands',
            'Micronesia',
            'Nauru',
            'New Zealand',
            'Palau',
            'Samoa',
            'Solomon Islands',
            'Vanuatu',
        ];
        
        foreach ($data as $datum) {
            Country::factory()->create(['name' => $datum]);
        }
    }
}
