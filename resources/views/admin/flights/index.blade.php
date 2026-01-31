@extends('layouts.admin')

@section('title', 'Flights Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Flights</h2>
        <a href="{{ route('admin.flights.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Flight
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Flight #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Route</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Schedule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($flights as $flight)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm font-bold">{{ $flight->flight_call }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $flight->schedule->originAirport->iata_airport_code }}
                            →
                            {{ $flight->schedule->destinationAirport->iata_airport_code }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ date('Y-m-d H:i', strtotime($flight->schedule->departure_time_gmt)) }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="px-2 py-1 rounded text-xs {{ $flight->status->name == 'Scheduled' ? 'bg-green-900 text-green-300' : ($flight->status->name == 'Cancelled' ? 'bg-red-900 text-red-300' : 'bg-yellow-900 text-yellow-300') }}">
                                {{ $flight->status->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('admin.flights.edit', $flight->flight_call) }}"
                                class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form action="{{ route('admin.flights.destroy', $flight->flight_call) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"
                                    onclick="return confirm('Delete this flight?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No flights found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $flights->links() }}
    </div>
@endsection