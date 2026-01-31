<?php

namespace Database\Seeders;

use App\Models\FlightStatus;
use Illuminate\Database\Seeder;

class FlightStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Scheduled'],
            ['name' => 'Boarding'],
            ['name' => 'Departed'],
            ['name' => 'In Flight'],
            ['name' => 'Landed'],
            ['name' => 'Delayed'],
            ['name' => 'Cancelled'],
            ['name' => 'Completed'],
        ];

        foreach ($statuses as $status) {
            FlightStatus::create($status);
        }
    }
}
