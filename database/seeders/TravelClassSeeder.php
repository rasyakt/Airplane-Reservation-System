<?php

namespace Database\Seeders;

use App\Models\TravelClass;
use Illuminate\Database\Seeder;

class TravelClassSeeder extends Seeder
{
    public function run(): void
    {
        $travelClasses = [
            [
                'name' => 'Economy',
                'description' => 'Standard seating with basic amenities and complimentary snacks and beverages.',
            ],
            [
                'name' => 'Premium Economy',
                'description' => 'Enhanced comfort with extra legroom, priority boarding, and upgraded meal service.',
            ],
            [
                'name' => 'Business',
                'description' => 'Luxury seating with lie-flat beds, gourmet dining, and access to exclusive lounges.',
            ],
            [
                'name' => 'First Class',
                'description' => 'Ultimate luxury with private suites, personalized service, and premium amenities.',
            ],
        ];

        foreach ($travelClasses as $travelClass) {
            TravelClass::create($travelClass);
        }
    }
}
