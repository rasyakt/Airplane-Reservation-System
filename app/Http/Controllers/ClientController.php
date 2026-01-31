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
    public function create()
    {
        $countries = Country::all();
        return view('clients.create', compact('countries'));
    }

    /**
     * Register a new client
     */
    public function register(Request $request)
    {
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
