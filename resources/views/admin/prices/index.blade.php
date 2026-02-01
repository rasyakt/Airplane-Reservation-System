@extends('layouts.admin')

@section('title', 'Flight Pricing')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Set and manage ticket prices for each flight and travel class</p>
        </div>
    </div>

    <div class="card">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Flight #</th>
                        <th>Route</th>
                        <th>Aircraft</th>
                        <th>Departure</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($flights as $flight)
                        <tr>
                            <td>
                                <span class="font-bold text-primary-600">{{ $flight->flight_call }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="font-semibold">{{ $flight->schedule->originAirport->iata_airport_code }}</span>
                                    <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                    <span
                                        class="font-semibold">{{ $flight->schedule->destinationAirport->iata_airport_code }}</span>
                                </div>
                            </td>
                            <td>{{ $flight->aircraftInstances->first()?->aircraft->model ?? 'N/A' }}</td>
                            <td>{{ date('M j, Y - H:i', strtotime($flight->schedule->departure_time_gmt)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.prices.edit', $flight->flight_call) }}"
                                    class="px-3 py-1.5 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition text-sm font-medium">
                                    <i class="fas fa-dollar-sign mr-1"></i>Set Prices
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <i class="fas fa-tags text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No flights found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $flights->links() }}
    </div>
@endsection