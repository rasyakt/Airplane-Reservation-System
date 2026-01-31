<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['iata_country_code' => 'ID', 'name' => 'Indonesia'],
            ['iata_country_code' => 'SG', 'name' => 'Singapore'],
            ['iata_country_code' => 'MY', 'name' => 'Malaysia'],
            ['iata_country_code' => 'TH', 'name' => 'Thailand'],
            ['iata_country_code' => 'US', 'name' => 'United States'],
            ['iata_country_code' => 'GB', 'name' => 'United Kingdom'],
            ['iata_country_code' => 'AU', 'name' => 'Australia'],
            ['iata_country_code' => 'JP', 'name' => 'Japan'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
