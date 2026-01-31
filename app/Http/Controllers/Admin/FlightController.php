<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Schedule;
use App\Models\FlightStatus;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::with(['schedule.originAirport', 'schedule.destinationAirport', 'status'])->paginate(20);
        return view('admin.flights.index', compact('flights'));
    }

    public function create()
    {
        $schedules = Schedule::with(['originAirport', 'destinationAirport'])->get();
        $statuses = FlightStatus::all();
        return view('admin.flights.create', compact('schedules', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'flight_status_id' => 'required|exists:flight_statuses,flight_status_id',
        ]);

        Flight::create($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight created successfully.');
    }

    public function show(Flight $flight)
    {
        $flight->load(['schedule.originAirport', 'schedule.destinationAirport', 'status', 'aircraftInstances', 'bookings']);
        return view('admin.flights.show', compact('flight'));
    }

    public function edit(Flight $flight)
    {
        $schedules = Schedule::with(['originAirport', 'destinationAirport'])->get();
        $statuses = FlightStatus::all();
        return view('admin.flights.edit', compact('flight', 'schedules', 'statuses'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'flight_status_id' => 'required|exists:flight_statuses,flight_status_id',
        ]);

        $flight->update($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight updated successfully.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight deleted successfully.');
    }
}
