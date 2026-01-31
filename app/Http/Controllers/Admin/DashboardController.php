<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Airport;
use App\Models\Aircraft;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalRevenue = Booking::join('flight_seat_prices', function ($join) {
            $join->on('bookings.flight_call', '=', 'flight_seat_prices.flight_call')
                ->on('bookings.aircraft_id', '=', 'flight_seat_prices.aircraft_id')
                ->on('bookings.seat_id', '=', 'flight_seat_prices.seat_id');
        })->sum('flight_seat_prices.price_usd');

        $totalBookings = Booking::count();
        $totalFlights = Flight::count();
        $totalAirports = Airport::count();

        // Recent Bookings
        $recentBookings = Booking::with(['client', 'flight.schedule.originAirport', 'flight.schedule.destinationAirport'])
            ->latest()
            ->take(5)
            ->get();

        // Top Routes
        $topRoutes = DB::table('bookings')
            ->join('flights', 'bookings.flight_call', '=', 'flights.flight_call')
            ->join('schedules', 'flights.schedule_id', '=', 'schedules.schedule_id')
            ->join('airports as origin', 'schedules.origin_iata_airport_code', '=', 'origin.iata_airport_code')
            ->join('airports as dest', 'schedules.dest_iata_airport_code', '=', 'dest.iata_airport_code')
            ->select('origin.city as origin_city', 'dest.city as dest_city', DB::raw('count(*) as booking_count'))
            ->groupBy('origin_city', 'dest_city')
            ->orderByDesc('booking_count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'totalFlights',
            'totalAirports',
            'recentBookings',
            'topRoutes'
        ));
    }
}
