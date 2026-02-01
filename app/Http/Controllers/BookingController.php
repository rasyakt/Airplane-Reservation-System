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
            $booking = DB::transaction(function () use ($validated) {
                // Lock the seat to prevent double booking
                $seat = AircraftSeat::lockForUpdate()
                    ->where('seat_id', $validated['seat_id'])
                    ->first();

                // Check if seat is still available
                if (!Booking::isSeatAvailable($validated['flight_call'], $validated['seat_id'])) {
                    throw new \Exception('Sorry, this seat has just been booked by another passenger.');
                }

                // Get seat price
                $seatPrice = FlightSeatPrice::where('flight_call', $validated['flight_call'])
                    ->where('aircraft_id', $validated['aircraft_id'])
                    ->where('seat_id', $validated['seat_id'])
                    ->value('price_usd');

                if (!$seatPrice) {
                    throw new \Exception('Price not found for this seat.');
                }

                // Calculate PPN (VAT)
                // Default: 11% (Domestic)
                // International: 0%
                // DTP Period (22 Oct 2025 - 10 Jan 2026): 5%

                // Get Schedule to check route & date
                $flight = Flight::with('schedule.originAirport', 'schedule.destinationAirport')
                    ->where('flight_call', $validated['flight_call'])
                    ->firstOrFail();

                $originCountry = $flight->schedule->originAirport->iata_country_code;
                $destCountry = $flight->schedule->destinationAirport->iata_country_code;

                $isDomestic = ($originCountry == 'ID' && $destCountry == 'ID');
                $isInternational = !$isDomestic;

                // Check DTP Period
                $dtpStart = \Carbon\Carbon::create(2025, 10, 22);
                $dtpEnd = \Carbon\Carbon::create(2026, 1, 10);
                $flightDate = $flight->schedule->departure_time_gmt; // Assumed to be cast to Carbon in model, otherwise parse it
                $isDtpPeriod = \Carbon\Carbon::parse($flightDate)->between($dtpStart, $dtpEnd);

                $taxRate = 0.11; // Default Normal Domestic

                if ($isInternational) {
                    $taxRate = 0;
                } elseif ($isDtpPeriod) {
                    $taxRate = 0.05; // 11% - 6% Gov Support = 5%
                }

                $vat = $seatPrice * $taxRate;
                $adminFee = 1.00;
                $totalPrice = $seatPrice + $vat + $adminFee;

                // Create booking
                return Booking::create([
                    'client_id' => $validated['client_id'],
                    'flight_call' => $validated['flight_call'],
                    'aircraft_id' => $validated['aircraft_id'],
                    'seat_id' => $validated['seat_id'],
                    'payment_status' => 'pending',
                    'total_price' => $totalPrice,
                    'tax_amount' => $vat,
                ]);
            });

            $booking = Booking::with(['client', 'flight.schedule.originAirport', 'flight.schedule.destinationAirport', 'seat.travelClass'])
                ->where('client_id', $validated['client_id'])
                ->where('flight_call', $validated['flight_call'])
                ->where('seat_id', $validated['seat_id'])
                ->first();

            // Redirect to payment page
            return redirect()->route('bookings.payment', $booking->confirmation_code);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show dummy payment page
     */
    public function payment($confirmationCode)
    {
        $booking = Booking::with(['client', 'flight.schedule', 'seat.travelClass', 'seat.flightSeatPrices'])
            ->where('confirmation_code', $confirmationCode)
            ->firstOrFail();

        return view('bookings.payment', compact('booking'));
    }

    /**
     * Process dummy payment
     */
    public function processPayment(Request $request, $confirmationCode)
    {
        $booking = Booking::with(['client', 'flight.schedule.originAirport', 'flight.schedule.destinationAirport', 'seat.travelClass'])
            ->where('confirmation_code', $confirmationCode)
            ->firstOrFail();

        // Simulate payment success
        // Use composite keys via DB facade since Eloquent primary key is null
        DB::table('bookings')
            ->where('client_id', $booking->client_id)
            ->where('flight_call', $booking->flight_call)
            ->where('aircraft_id', $booking->aircraft_id)
            ->where('seat_id', $booking->seat_id)
            ->update(['payment_status' => 'completed', 'updated_at' => now()]);

        // Reload booking to get the updated status for the mail
        $booking->payment_status = 'completed';

        // Send confirmation email NOW after payment
        if ($booking->client->email) {
            \Illuminate\Support\Facades\Mail::to($booking->client->email)->send(new \App\Mail\BookingConfirmation($booking));
        }

        return redirect()->route('bookings.confirmation', $booking->confirmation_code)
            ->with('success', 'Payment successful and booking confirmed!');
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
