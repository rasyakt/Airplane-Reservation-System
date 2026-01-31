<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\AircraftManufacturer;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    public function index()
    {
        $aircraft = Aircraft::with('manufacturer')->paginate(20);
        return view('admin.aircraft.index', compact('aircraft'));
    }

    public function create()
    {
        $manufacturers = AircraftManufacturer::all();
        return view('admin.aircraft.create', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aircraft_manufacturer_id' => 'required|exists:aircraft_manufacturers,aircraft_manufacturer_id',
            'model' => 'required|string|max:45',
        ]);

        Aircraft::create($validated);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft created successfully.');
    }

    public function show(Aircraft $aircraft)
    {
        $aircraft->load(['manufacturer', 'instances', 'seats.travelClass']);
        return view('admin.aircraft.show', compact('aircraft'));
    }

    public function edit(Aircraft $aircraft)
    {
        $manufacturers = AircraftManufacturer::all();
        return view('admin.aircraft.edit', compact('aircraft', 'manufacturers'));
    }

    public function update(Request $request, Aircraft $aircraft)
    {
        $validated = $request->validate([
            'aircraft_manufacturer_id' => 'required|exists:aircraft_manufacturers,aircraft_manufacturer_id',
            'model' => 'required|string|max:45',
        ]);

        $aircraft->update($validated);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft updated successfully.');
    }

    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft deleted successfully.');
    }
}
