<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            // Indonesian Airports
            ['iata_airport_code' => 'CGK', 'name' => 'Soekarno-Hatta International Airport', 'city' => 'Jakarta', 'iata_country_code' => 'ID'],
            ['iata_airport_code' => 'DPS', 'name' => 'Ngurah Rai International Airport', 'city' => 'Denpasar', 'iata_country_code' => 'ID'],
            ['iata_airport_code' => 'SUB', 'name' => 'Juanda International Airport', 'city' => 'Surabaya', 'iata_country_code' => 'ID'],
            ['iata_airport_code' => 'UPG', 'name' => 'Sultan Hasanuddin International Airport', 'city' => 'Makassar', 'iata_country_code' => 'ID'],
            ['iata_airport_code' => 'JOG', 'name' => 'Adisucipto International Airport', 'city' => 'Yogyakarta', 'iata_country_code' => 'ID'],

            // International Airports
            ['iata_airport_code' => 'SIN', 'name' => 'Singapore Changi Airport', 'city' => 'Singapore', 'iata_country_code' => 'SG'],
            ['iata_airport_code' => 'KUL', 'name' => 'Kuala Lumpur International Airport', 'city' => 'Kuala Lumpur', 'iata_country_code' => 'MY'],
            ['iata_airport_code' => 'BKK', 'name' => 'Suvarnabhumi Airport', 'city' => 'Bangkok', 'iata_country_code' => 'TH'],
            ['iata_airport_code' => 'NRT', 'name' => 'Narita International Airport', 'city' => 'Tokyo', 'iata_country_code' => 'JP'],
            ['iata_airport_code' => 'SYD', 'name' => 'Sydney Kingsford Smith International Airport', 'city' => 'Sydney', 'iata_country_code' => 'AU'],
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}
