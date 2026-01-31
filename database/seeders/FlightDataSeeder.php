<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use App\Models\AircraftInstance;
use App\Models\AircraftManufacturer;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightStatus;
use App\Models\Schedule;
use App\Models\TravelClass;
use App\Models\AircraftSeat;
use App\Models\FlightSeatPrice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FlightDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get references
        $manufacturer = AircraftManufacturer::first();
        $economyClass = TravelClass::where('name', 'Economy')->first();
        $businessClass = TravelClass::where('name', 'Business')->first();
        $firstClass = TravelClass::where('name', 'First Class')->first();
        $statusScheduled = FlightStatus::where('name', 'Scheduled')->first();

        $cgk = Airport::where('iata_airport_code', 'CGK')->first();
        $sin = Airport::where('iata_airport_code', 'SIN')->first();
        $dps = Airport::where('iata_airport_code', 'DPS')->first();

        if (!$cgk || !$sin || !$dps) {
            return;
        }

        // 2. Create Aircraft
        $aircraft = Aircraft::create([
            'aircraft_manufacturer_id' => $manufacturer->aircraft_manufacturer_id,
            'model' => 'Airbus A320',
        ]);

        // 3. Create Aircraft Instance
        $instance = AircraftInstance::create([
            'aircraft_id' => $aircraft->aircraft_id,
            'registration_number' => 'PK-GAI',
        ]);

        // 4. Create Seats (Simplified grid)
        $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
        for ($row = 1; $row <= 10; $row++) {
            foreach ($rows as $col) {
                $classId = ($row <= 2) ? $firstClass->travel_class_id : (($row <= 5) ? $businessClass->travel_class_id : $economyClass->travel_class_id);
                AircraftSeat::create([
                    'aircraft_id' => $aircraft->aircraft_id,
                    'seat_number' => $row . $col,
                    'travel_class_id' => $classId,
                ]);
            }
        }

        // 5. Create Schedules (Today and Tomorrow)
        $schedules = [
            [
                'origin_iata_airport_code' => 'CGK',
                'dest_iata_airport_code' => 'SIN',
                'departure_time_gmt' => Carbon::now()->addHours(5),
                'arrival_time_gmt' => Carbon::now()->addHours(7),
                'callsign' => 'GA202',
            ],
            [
                'origin_iata_airport_code' => 'SIN',
                'dest_iata_airport_code' => 'CGK',
                'departure_time_gmt' => Carbon::now()->addHours(10),
                'arrival_time_gmt' => Carbon::now()->addHours(12),
                'callsign' => 'GA203',
            ],
            [
                'origin_iata_airport_code' => 'CGK',
                'dest_iata_airport_code' => 'DPS',
                'departure_time_gmt' => Carbon::tomorrow()->setTime(10, 0),
                'arrival_time_gmt' => Carbon::tomorrow()->setTime(12, 0),
                'callsign' => 'GA401',
            ],
        ];

        foreach ($schedules as $s) {
            $schedule = Schedule::create($s);

            // 6. Create Flight
            $flight = Flight::create([
                'flight_call' => $s['callsign'] . '-' . Carbon::parse($s['departure_time_gmt'])->format('Ymd'),
                'schedule_id' => $schedule->schedule_id,
                'flight_status_id' => $statusScheduled->flight_status_id,
            ]);

            // 7. Set Seat Prices for this flight
            $seats = AircraftSeat::where('aircraft_id', $aircraft->aircraft_id)->get();
            foreach ($seats as $seat) {
                $price = 100; // Economy
                if ($seat->travel_class_id == $businessClass->travel_class_id)
                    $price = 250;
                if ($seat->travel_class_id == $firstClass->travel_class_id)
                    $price = 600;

                FlightSeatPrice::create([
                    'flight_call' => $flight->flight_call,
                    'aircraft_id' => $aircraft->aircraft_id,
                    'seat_id' => $seat->seat_id,
                    'price_usd' => $price,
                ]);
            }
        }
    }
}
