@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Monitor and manage all passenger reservations</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Total Bookings</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $bookings->total() }}</div>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Total Passengers</div>
                    <div class="text-3xl font-bold text-gray-900">{{ \App\Models\Client::count() }}</div>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Active Flights</div>
                    <div class="text-3xl font-bold text-gray-900">{{ \App\Models\Flight::count() }}</div>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plane-departure text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Passenger</th>
                        <th>Flight</th>
                        <th>Route</th>
                        <th>Seat</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>
                                <span class="font-bold text-primary-600">{{ $booking->confirmation_code }}</span>
                            </td>
                            <td>
                                <div class="text-sm font-semibold text-gray-900">{{ $booking->client->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->client->email }}</div>
                            </td>
                            <td>
                                <span class="badge-info">{{ $booking->flight_call }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2 text-sm">
                                    <span>{{ $booking->flight->schedule->originAirport->iata_airport_code }}</span>
                                    <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                    <span>{{ $booking->flight->schedule->destinationAirport->iata_airport_code }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <span class="font-medium">#{{ $booking->seat_id }}</span>
                                    <span
                                        class="text-xs text-gray-500">({{ $booking->seat->travelClass->name ?? 'N/A' }})</span>
                                </div>
                            </td>
                            <td>
                                @if ($booking->payment_status == 'paid')
                                    <span class="badge-success"><i class="fas fa-check-circle mr-1"></i>Paid</span>
                                @else
                                    <span class="badge-warning"><i class="fas fa-clock mr-1"></i>Pending</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->confirmation_code) }}"
                                        class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <form action="{{ route('admin.bookings.destroy', $booking->confirmation_code) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium"
                                            onclick="return confirm('Cancel and delete this booking?')">
                                            <i class="fas fa-times mr-1"></i>Cancel
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <i class="fas fa-ticket-alt text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No bookings found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
@endsection