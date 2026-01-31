<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['client', 'flight.schedule.originAirport', 'flight.schedule.destinationAirport', 'seat.travelClass'])
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($confirmationCode)
    {
        $booking = Booking::with(['client', 'flight.schedule.originAirport', 'flight.schedule.destinationAirport', 'seat.travelClass', 'aircraft'])
            ->where('confirmation_code', $confirmationCode)
            ->firstOrFail();

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy($confirmationCode)
    {
        $booking = Booking::where('confirmation_code', $confirmationCode)->firstOrFail();

        // In a real system, you might want to handle refunds or notification logic here
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking cancelled successfully.');
    }
}
