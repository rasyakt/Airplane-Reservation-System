<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\AircraftSeat;
use App\Models\FlightSeatPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display the homepage with flight search form
     */
    public function index()
    {
        $airports = Airport::all();
        return view('welcome', compact('airports'));
    }

    /**
     * Search for flights
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|size:3|exists:airports,iata_airport_code',
            'destination' => 'required|size:3|exists:airports,iata_airport_code|different:origin',
            'departure_date' => 'required|date|after_or_equal:today',
        ]);

        $flights = Flight::with(['schedule.originAirport', 'schedule.destinationAirport', 'status', 'flightSeatPrices'])
            ->whereHas('schedule', function ($query) use ($validated) {
                $query->where('origin_iata_airport_code', $validated['origin'])
                    ->where('dest_iata_airport_code', $validated['destination'])
                    ->where('departure_time_gmt', '>', now()) // Only future flights
                    ->whereDate('departure_time_gmt', $validated['departure_date']);
            })
            ->whereHas('status', function ($query) {
                $query->whereIn('name', ['Scheduled', 'Boarding']);
            })
            ->get()
            ->map(function ($flight) {
                $flight->min_price = $flight->flightSeatPrices->min('price_usd') ?? 0;
                return $flight;
            });

        $searchParams = $validated;
        return view('bookings.search', compact('flights', 'searchParams'));
    }

    /**
     * Show flight details and available seats
     */
    public function show(Flight $flight)
    {
        $flight->load([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'status',
            'flightSeatPrices.seat.travelClass'
        ]);

        // Get booked seats for this flight
        $bookedSeats = Booking::where('flight_call', $flight->flight_call)
            ->pluck('seat_id')
            ->toArray();

        // Get available seats with prices
        $availableSeats = $flight->flightSeatPrices()
            ->with('seat.travelClass')
            ->whereNotIn('seat_id', $bookedSeats)
            ->get();

        return view('bookings.show', compact('flight', 'availableSeats', 'bookedSeats'));
    }

    /**
     * Process booking confirmation
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'flight_call' => 'required|exists:flights,flight_call',
            'seat_id' => 'required|exists:aircraft_seats,seat_id',
            'aircraft_id' => 'required|exists:aircraft,aircraft_id',
            'client_id' => 'required|exists:clients,client_id',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Lock the seat to prevent double booking
                $seat = AircraftSeat::lockForUpdate()
                    ->where('seat_id', $validated['seat_id'])
                    ->first();

                // Check if seat is still available
                if (!Booking::isSeatAvailable($validated['flight_call'], $validated['seat_id'])) {
                    throw new \Exception('Sorry, this seat has just been booked by another passenger.');
                }

                // Create booking
                Booking::create([
                    'client_id' => $validated['client_id'],
                    'flight_call' => $validated['flight_call'],
                    'aircraft_id' => $validated['aircraft_id'],
                    'seat_id' => $validated['seat_id'],
                    'payment_status' => 'pending',
                ]);
            });

            $booking = Booking::with(['client', 'flight.schedule', 'seat.travelClass'])
                ->where('client_id', $validated['client_id'])
                ->where('flight_call', $validated['flight_call'])
                ->where('seat_id', $validated['seat_id'])
                ->first();

            return redirect()->route('bookings.confirmation', $booking->confirmation_code)
                ->with('success', 'Booking confirmed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show booking confirmation
     */
    public function confirmation($confirmationCode)
    {
        $booking = Booking::with([
            'client',
            'flight.schedule.originAirport',
            'flight.schedule.destinationAirport',
            'seat.travelClass'
        ])
            ->where('confirmation_code', $confirmationCode)
            ->firstOrFail();

        return view('bookings.confirmation', compact('booking'));
    }
}
