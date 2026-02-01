<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Show client registration form
     */
    /**
     * Show client registration form
     */
    public function create(Request $request)
    {
        $flightCall = $request->query('flight_call');
        if (!$flightCall) {
            return redirect()->route('home');
        }

        $flight = \App\Models\Flight::with(['schedule.originAirport', 'schedule.destinationAirport'])->where('flight_call', $flightCall)->firstOrFail();
        $countries = Country::all();
        return view('clients.create', compact('countries', 'flight'));
    }

    /**
     * Store passenger data and redirect to seat selection
     */
    public function storePassenger(Request $request)
    {
        $validated = $request->validate([
            'flight_call' => 'required|exists:flights,flight_call',
            'first_name' => 'required|string|max:45',
            'middle_name' => 'nullable|string|max:45',
            'last_name' => 'required|string|max:45',
            'phone' => 'required|string|max:45',
            'email' => 'required|email|max:45', // Check uniqueness later or handle return customer
            'passport' => 'required|string|max:45',
            'iata_country_code' => 'required|size:2|exists:countries,iata_country_code',
        ]);

        // Find or create client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            $validated
        );

        // Update if exists (optional, but good for returning users)
        $client->update($validated);

        // Store confirmed client ID in session for the next step
        session(['booking_client_id' => $client->client_id]);
        session(['booking_flight_call' => $validated['flight_call']]);

        // Redirect to Seat Selection
        return redirect()->route('flights.show', $validated['flight_call']);
    }

    /**
     * Register a new client (Legacy/API)
     */
    public function register(Request $request)
    {
        // ... (keep existing logic if needed, or deprecate)
        $validated = $request->validate([
            'first_name' => 'required|string|max:45',
            'middle_name' => 'nullable|string|max:45',
            'last_name' => 'required|string|max:45',
            'phone' => 'required|string|max:45',
            'email' => 'required|email|max:45|unique:clients,email',
            'passport' => 'required|string|max:45',
            'iata_country_code' => 'required|size:2|exists:countries,iata_country_code',
        ]);

        $client = Client::create($validated);

        return response()->json([
            'success' => true,
            'client_id' => $client->client_id,
            'message' => 'Client registered successfully',
        ]);
    }

    /**
     * Check email availability (AJAX)
     */
    public function checkEmail(Request $request)
    {
        $exists = Client::where('email', $request->email)->exists();

        return response()->json([
            'available' => !$exists,
        ]);
    }
}
