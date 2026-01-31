<?php

namespace Database\Seeders;

use App\Models\AircraftManufacturer;
use Illuminate\Database\Seeder;

class AircraftManufacturerSeeder extends Seeder
{
    public function run(): void
    {
        $manufacturers = [
            ['name' => 'Boeing'],
            ['name' => 'Airbus'],
            ['name' => 'Embraer'],
            ['name' => 'Bombardier'],
            ['name' => 'ATR Aircraft'],
        ];

        foreach ($manufacturers as $manufacturer) {
            AircraftManufacturer::create($manufacturer);
        }
    }
}
