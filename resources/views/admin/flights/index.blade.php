@extends('layouts.admin')

@section('title', 'Flights Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Active Flights</h2>
            <p class="text-sm text-gray-500 mt-1">Monitor and manage all scheduled aircraft operations.</p>
        </div>
        <a href="{{ route('admin.flights.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Flight
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Flight #</th>
                        <th>Route</th>
                        <th>Schedule Ref</th>
                        <th>Status</th>
                        <th>Bookings</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($flights as $flight)
                        <tr>
                            <td>
                                <span class="font-bold text-gray-900 tracking-wider">{{ $flight->flight_call }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="badge-primary">{{ $flight->schedule->origin_iata_airport_code }}</span>
                                    <i class="fas fa-arrow-right text-gray-300"></i>
                                    <span class="badge-secondary">{{ $flight->schedule->destination_iata_airport_code }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-xs font-semibold text-gray-700">{{ $flight->schedule->callsign }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5 uppercase">
                                    {{ $flight->schedule->departure_time_gmt->format('D, d M H:i') }} GMT</div>
                            </td>
                            <td>
                                @if ($flight->status->name == 'Scheduled')
                                    <span class="badge-success">{{ $flight->status->name }}</span>
                                @elseif ($flight->status->name == 'Cancelled')
                                    <span class="badge-danger">{{ $flight->status->name }}</span>
                                @else
                                    <span class="badge-warning">{{ $flight->status->name }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-sm font-bold text-primary-600">{{ $flight->bookings->count() }}</div>
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.flights.show', $flight->flight_call) }}"
                                        class="p-2 text-gray-400 hover:text-primary-600 transition" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.flights.edit', $flight->flight_call) }}"
                                        class="p-2 text-gray-400 hover:text-secondary-600 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.flights.destroy', $flight->flight_call) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Delete this flight?')">
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
                                    <i class="fas fa-plane-slash text-4xl text-gray-200 mb-4"></i>
                                    <p class="text-gray-500">No flights found. Scheduled flights will appear here.</p>
                                </div>
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