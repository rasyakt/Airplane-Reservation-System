@extends('layouts.admin')

@section('title', 'Flight Search Results')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Search Results</h2>
        <p class="text-gray-400">
            {{ $searchParams['origin'] }} → {{ $searchParams['destination'] }}
            on {{ date('F j, Y', strtotime($searchParams['departure_date'])) }}
        </p>
    </div>

    @if ($flights->isEmpty())
        <div class="bg-gray-800 rounded-lg p-12 text-center">
            <div class="text-6xl mb-4">✈️</div>
            <h3 class="text-xl font-semibold mb-2">No Flights Found</h3>
            <p class="text-gray-400 mb-6">There are no available flights for this route on the selected date.</p>
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                ← Search Again
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($flights as $flight)
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-750 transition">
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            <div class="flex items-center gap-8 mb-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">
                                        {{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</div>
                                    <div class="text-sm text-gray-400">{{ $flight->schedule->originAirport->iata_airport_code }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-center">
                                        <div class="h-px bg-gray-600 flex-1"></div>
                                        <div class="px-4 text-gray-400">✈️</div>
                                        <div class="h-px bg-gray-600 flex-1"></div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">
                                        {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</div>
                                    <div class="text-sm text-gray-400">
                                        {{ $flight->schedule->destinationAirport->iata_airport_code }}</div>
                                </div>
                            </div>
                            <div class="flex gap-4 text-sm text-gray-400">
                                <span>Flight {{ $flight->flight_call }}</span>
                                <span>•</span>
                                <span
                                    class="px-2 py-1 rounded {{ $flight->status->name == 'Scheduled' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">
                                    {{ $flight->status->name }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('flights.show', $flight->flight_call) }}"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-block">
                                Select Flight →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection