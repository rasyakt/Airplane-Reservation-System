@extends('layouts.admin')

@section('title', 'Schedules Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Flight Schedules</h2>
            <p class="text-sm text-gray-500 mt-1">Manage and monitor all flight routes and timings.</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Schedule
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Callsign</th>
                        <th>Route</th>
                        <th>Departure (GMT)</th>
                        <th>Arrival (GMT)</th>
                        <th>Flights</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td>
                                <span class="font-bold text-gray-900">{{ $schedule->callsign }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="badge-primary">{{ $schedule->origin_iata_airport_code }}</span>
                                    <i class="fas fa-long-arrow-alt-right text-gray-300"></i>
                                    <span class="badge-secondary">{{ $schedule->dest_iata_airport_code }}</span>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1 uppercase">
                                    {{ $schedule->originAirport->city }} to {{ $schedule->destinationAirport->city }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $schedule->departure_time_gmt->format('H:i') }}</div>
                                <div class="text-[10px] text-gray-500 uppercase">
                                    {{ $schedule->departure_time_gmt->format('D, d M') }}</div>
                            </td>
                            <td>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $schedule->arrival_time_gmt->format('H:i') }}</div>
                                <div class="text-[10px] text-gray-500 uppercase">
                                    {{ $schedule->arrival_time_gmt->format('D, d M') }}</div>
                            </td>
                            <td>
                                <span class="badge-info">{{ $schedule->flights->count() }} Flights</span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.schedules.show', $schedule->schedule_id) }}"
                                        class="p-2 text-gray-400 hover:text-primary-600 transition" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}"
                                        class="p-2 text-gray-400 hover:text-secondary-600 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-4xl text-gray-200 mb-4"></i>
                                    <p class="text-gray-500">No schedules found. Start by adding a new one!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $schedules->links() }}
    </div>
@endsection