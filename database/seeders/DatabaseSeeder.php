<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data tables first (no dependencies)
        $this->call([
            CountrySeeder::class,
            AirportSeeder::class,
            AircraftManufacturerSeeder::class,
            TravelClassSeeder::class,
            FlightStatusSeeder::class,
            FlightDataSeeder::class,
        ]);

        // Create default admin user for testing
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@airplane.com',
        ]);
    }
}
