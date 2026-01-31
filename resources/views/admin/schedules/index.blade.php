@extends('layouts.admin')

@section('title', 'Schedules Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Flight Schedules</h2>
        <a href="{{ route('admin.schedules.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Schedule
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Route</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Departure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Arrival</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($schedules as $schedule)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm font-medium">{{ $schedule->schedule_id }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="font-semibold">{{ $schedule->originAirport->iata_airport_code }}</span>
                            →
                            <span class="font-semibold">{{ $schedule->destinationAirport->iata_airport_code }}</span>
                            <div class="text-xs text-gray-400">
                                {{ $schedule->originAirport->city }} - {{ $schedule->destinationAirport->city }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ date('H:i', strtotime($schedule->departure_time_gmt)) }} GMT</td>
                        <td class="px-6 py-4 text-sm">{{ date('H:i', strtotime($schedule->arrival_time_gmt)) }} GMT</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}"
                                class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"
                                    onclick="return confirm('Delete this schedule?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No schedules found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
@endsection