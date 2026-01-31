<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Airport;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['originAirport', 'destinationAirport'])->paginate(20);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $airports = Airport::all();
        return view('admin.schedules.create', compact('airports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_iata_airport_code' => 'required|size:3|exists:airports,iata_airport_code',
            'dest_iata_airport_code' => 'required|size:3|exists:airports,iata_airport_code|different:origin_iata_airport_code',
            'departure_time_gmt' => 'required|date',
            'arrival_time_gmt' => 'required|date|after:departure_time_gmt',
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['originAirport', 'destinationAirport', 'flights']);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $airports = Airport::all();
        return view('admin.schedules.edit', compact('schedule', 'airports'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'origin_iata_airport_code' => 'required|size:3|exists:airports,iata_airport_code',
            'dest_iata_airport_code' => 'required|size:3|exists:airports,iata_airport_code|different:origin_iata_airport_code',
            'departure_time_gmt' => 'required|date',
            'arrival_time_gmt' => 'required|date|after:departure_time_gmt',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
