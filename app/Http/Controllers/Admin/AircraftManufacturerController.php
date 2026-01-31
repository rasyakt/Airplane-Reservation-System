<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AircraftManufacturer;
use Illuminate\Http\Request;

class AircraftManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = AircraftManufacturer::withCount('aircraft')->paginate(20);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45|unique:aircraft_manufacturers,name',
        ]);

        AircraftManufacturer::create($validated);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer created successfully.');
    }

    public function show(AircraftManufacturer $manufacturer)
    {
        $manufacturer->load('aircraft');
        return view('admin.manufacturers.show', compact('manufacturer'));
    }

    public function edit(AircraftManufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, AircraftManufacturer $manufacturer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45|unique:aircraft_manufacturers,name,' . $manufacturer->aircraft_manufacturer_id . ',aircraft_manufacturer_id',
        ]);

        $manufacturer->update($validated);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy(AircraftManufacturer $manufacturer)
    {
        $manufacturer->delete();

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer deleted successfully.');
    }
}
