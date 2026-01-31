<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\FlightSeatPrice;
use App\Models\TravelClass;
use Illuminate\Http\Request;

class FlightSeatPriceController extends Controller
{
    public function index()
    {
        $flights = Flight::with(['schedule.originAirport', 'schedule.destinationAirport'])->latest()->paginate(15);
        return view('admin.prices.index', compact('flights'));
    }

    public function edit($flightCall)
    {
        $flight = Flight::with(['schedule.originAirport', 'schedule.destinationAirport', 'aircraft.seats'])->where('flight_call', $flightCall)->firstOrFail();
        $travelClasses = TravelClass::all();

        // Get existing prices for this flight
        $existingPrices = FlightSeatPrice::where('flight_call', $flightCall)->get();

        return view('admin.prices.edit', compact('flight', 'travelClasses', 'existingPrices'));
    }

    public function update(Request $request, $flightCall)
    {
        $flight = Flight::where('flight_call', $flightCall)->firstOrFail();
        $aircraftId = $flight->aircraft->aircraft_id;

        $prices = $request->input('prices', []); // [class_id => price]

        foreach ($prices as $classId => $price) {
            if ($price <= 0)
                continue;

            // Get all seats for this aircraft and this class
            $seats = \App\Models\AircraftSeat::where('aircraft_id', $aircraftId)
                ->where('travel_class_id', $classId)
                ->get();

            foreach ($seats as $seat) {
                FlightSeatPrice::updateOrCreate(
                    [
                        'flight_call' => $flightCall,
                        'aircraft_id' => $aircraftId,
                        'seat_id' => $seat->seat_id,
                    ],
                    ['price_usd' => $price]
                );
            }
        }

        return redirect()->route('admin.prices.index')->with('success', 'Prices updated for all seats in selected classes.');
    }
}
