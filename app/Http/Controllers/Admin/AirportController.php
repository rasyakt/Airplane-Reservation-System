<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::with('country')->paginate(20);
        return view('admin.airports.index', compact('airports'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.airports.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'iata_airport_code' => 'required|size:3|regex:/^[A-Z]{3}$/|unique:airports,iata_airport_code',
            'name' => 'required|string|max:45',
            'city' => 'required|string|max:45',
            'iata_country_code' => 'required|size:2|exists:countries,iata_country_code',
        ]);

        Airport::create($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport created successfully.');
    }

    public function show(Airport $airport)
    {
        $airport->load('country');
        return view('admin.airports.show', compact('airport'));
    }

    public function edit($iata_airport_code)
    {
        $airport = Airport::findOrFail($iata_airport_code);
        $countries = Country::all();
        return view('admin.airports.edit', compact('airport', 'countries'));
    }

    public function update(Request $request, $iata_airport_code)
    {
        $airport = Airport::findOrFail($iata_airport_code);

        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'city' => 'required|string|max:45',
            'iata_country_code' => 'required|size:2|exists:countries,iata_country_code',
        ]);

        $airport->update($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport updated successfully.');
    }

    public function destroy($iata_airport_code)
    {
        $airport = Airport::findOrFail($iata_airport_code);
        $airport->delete();

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport deleted successfully.');
    }
}
