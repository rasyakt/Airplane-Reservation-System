@extends('layouts.admin')

@section('title', 'Flights Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Monitor and manage all flights</p>
        </div>
        <a href="{{ route('admin.flights.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>Add Flight
        </a>
    </div>

    <div class="card">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Flight #</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($flights as $flight)
                        <tr>
                            <td><span class="font-bold text-primary-600">{{ $flight->flight_call }}</span></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold">{{ $flight->schedule->originAirport->iata_airport_code }}</span>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                    <span
                                        class="font-semibold">{{ $flight->schedule->destinationAirport->iata_airport_code }}</span>
                                </div>
                            </td>
                            <td>{{ date('M j, Y - H:i', strtotime($flight->schedule->departure_time_gmt)) }}</td>
                            <td>
                                @if ($flight->status->name == 'Scheduled')
                                    <span class="badge-success"><i
                                            class="fas fa-check-circle mr-1"></i>{{ $flight->status->name }}</span>
                                @elseif ($flight->status->name == 'Cancelled')
                                    <span class="badge-danger"><i
                                            class="fas fa-times-circle mr-1"></i>{{ $flight->status->name }}</span>
                                @else
                                    <span class="badge-warning"><i class="fas fa-clock mr-1"></i>{{ $flight->status->name }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.flights.edit', $flight->flight_call) }}"
                                        class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium"><i
                                            class="fas fa-edit mr-1"></i>Edit</a>
                                    <form action="{{ route('admin.flights.destroy', $flight->flight_call) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium"
                                            onclick="return confirm('Delete this flight?')"><i
                                                class="fas fa-trash mr-1"></i>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12"><i
                                    class="fas fa-plane-slash text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No flights found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $flights->links() }}
    </div>
@endsection