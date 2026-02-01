@extends('layouts.admin')

@section('title', 'Flight Details')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.flights.index') }}"
                    class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-900">Flight {{ $flight->flight_call }}</h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.flights.edit', $flight->flight_call) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.flights.destroy', $flight->flight_call) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 border-red-600">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Flight Overview Card -->
                <div class="card p-8">
                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <div class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-1">Status</div>
                            @if($flight->status->name == 'Scheduled')
                                <span class="badge-success text-base px-4 py-2">{{ $flight->status->name }}</span>
                            @else
                                <span class="badge-info text-base px-4 py-2">{{ $flight->status->name }}</span>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-1">Route</div>
                            <div class="text-2xl font-black text-gray-900">
                                {{ $flight->schedule->origin_iata_airport_code }} →
                                {{ $flight->schedule->destination_iata_airport_code }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-10 p-6 bg-gray-50 rounded-3xl">
                        <div class="border-r border-gray-200">
                            <div class="text-xs font-bold text-gray-400 uppercase mb-3 text-center">Departure</div>
                            <div class="text-center">
                                <div class="text-3xl font-black text-primary-600">
                                    {{ $flight->schedule->departure_time_gmt->format('H:i') }}</div>
                                <div class="text-sm font-semibold text-gray-900 mt-1">
                                    {{ $flight->schedule->departure_time_gmt->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $flight->schedule->originAirport->city }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-400 uppercase mb-3 text-center">Arrival</div>
                            <div class="text-center">
                                <div class="text-3xl font-black text-secondary-600">
                                    {{ $flight->schedule->arrival_time_gmt->format('H:i') }}</div>
                                <div class="text-sm font-semibold text-gray-900 mt-1">
                                    {{ $flight->schedule->arrival_time_gmt->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $flight->schedule->destinationAirport->city }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings List -->
                <div class="card overflow-hidden">
                    <div class="card-header flex justify-between items-center">
                        <span>Recent Bookings</span>
                        <span class="badge-info">{{ $flight->bookings->count() }} Total</span>
                    </div>
                    <div class="table">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>Passenger</th>
                                    <th>Seat</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($flight->bookings->take(10) as $booking)
                                    <tr>
                                        <td>
                                            <div class="text-sm font-bold text-gray-900">{{ $booking->client->full_name }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase">{{ $booking->confirmation_code }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-secondary">{{ $booking->seat->seat_number }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge-{{ $booking->payment_status == 'completed' ? 'success' : 'warning' }} text-[10px]">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.bookings.show', $booking->confirmation_code) }}"
                                                class="text-primary-600 hover:underline text-xs font-bold">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-gray-500 text-sm">No bookings yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Components -->
            <div class="space-y-6">
                <div class="card p-6">
                    <div class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-widest">Aircraft Info</div>
                    @forelse($flight->aircraftInstances as $instance)
                        <div class="flex items-center gap-4 mb-4 last:mb-0">
                            <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center text-primary-600">
                                <i class="fas fa-plane"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $instance->aircraft->model }}</div>
                                <div class="text-xs text-gray-500">{{ $instance->registration_number }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">No aircraft assigned yet.</p>
                    @endforelse
                </div>

                <div class="card p-6">
                    <div class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-widest">Revenue Summary</div>
                    <div class="text-3xl font-black text-primary-600 mb-1">
                        ${{ number_format($flight->bookings->where('payment_status', 'completed')->sum(function ($b) {
        return $b->flight->flightSeatPrices->where('seat_id', $b->seat_id)->first()->price_usd ?? 0;
    }), 2) }}
                    </div>
                    <p class="text-xs text-gray-500">Total revenue from completed bookings</p>
                </div>
            </div>
        </div>
    </div>
@endsection