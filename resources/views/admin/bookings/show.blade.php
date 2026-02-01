@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.bookings.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Back to Bookings
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Header -->
            <div class="card overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-700 p-8 text-white">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <div class="text-sm opacity-90 mb-1">Confirmation Code</div>
                            <div class="text-4xl font-bold tracking-wider">{{ $booking->confirmation_code }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm opacity-90 mb-1">Payment Status</div>
                            <div
                                class="inline-block px-4 py-2 {{ $booking->payment_status == 'paid' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-lg font-semibold">
                                {{ ucfirst($booking->payment_status) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-4">Departure</h3>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $booking->flight->schedule->originAirport->city }}
                            </div>
                            <div class="text-gray-600 mb-2">{{ $booking->flight->schedule->originAirport->name }}</div>
                            <div class="text-primary-600 font-semibold">
                                {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->departure_time_gmt)) }} GMT
                            </div>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-4">Arrival</h3>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $booking->flight->schedule->destinationAirport->city }}
                            </div>
                            <div class="text-gray-600 mb-2">{{ $booking->flight->schedule->destinationAirport->name }}</div>
                            <div class="text-primary-600 font-semibold">
                                {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->arrival_time_gmt)) }} GMT
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger Details -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-circle text-primary-500 mr-2"></i>Passenger Information
                </div>
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Full Name</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->full_name }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Email</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->email }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Phone</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->phone }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Passport Number</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->passport }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Nationality</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->country->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plane text-primary-500 mr-2"></i>Flight & Seat
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Flight Number</span>
                            <span class="font-bold text-gray-900">{{ $booking->flight_call }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Aircraft</span>
                            <span class="font-medium text-gray-900">{{ $booking->aircraft->model ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Class</span>
                            <span class="badge-info">{{ $booking->seat->travelClass->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Seat Number</span>
                            <span class="font-bold text-secondary-600">#{{ $booking->seat_id }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Booking Date</span>
                                <span class="text-sm text-gray-900">{{ $booking->created_at->format('M j, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-file-invoice-dollar text-primary-500 mr-2"></i>Financials
                </div>
                <div class="card-body">
                    @php
                        $total = $booking->total_price ?? ($booking->seat->flightSeatPrices->where('flight_call', $booking->flight_call)->first()->price_usd * 1.11 + 1);
                        $price = $booking->seat->flightSeatPrices->where('flight_call', $booking->flight_call)->first()->price_usd;

                        // Recalculate if not stored (Legacy support)
                        if ($booking->tax_amount !== null) {
                            $vat = $booking->tax_amount;
                            $rate = ($price > 0) ? round($vat / $price, 2) : 0;
                        } else {
                            // Advanced Calculation Fallback
                            $originCountry = $booking->flight->schedule->originAirport->iata_country_code;
                            $destCountry = $booking->flight->schedule->destinationAirport->iata_country_code;
                            $flightDate = $booking->flight->schedule->departure_time_gmt;

                            $isDomestic = ($originCountry == 'ID' && $destCountry == 'ID');
                            $isInternational = !$isDomestic;
                            $isDtpPeriod = \Carbon\Carbon::parse($flightDate)->between('2025-10-22', '2026-01-10');

                            $rate = 0.11;
                            if ($isInternational)
                                $rate = 0;
                            elseif ($isDtpPeriod)
                                $rate = 0.05;

                            $vat = $price * $rate;
                        }

                        $basePrice = $price;
                        $vatLabel = "VAT (" . ($rate * 100) . "%)";
                        if ($rate == 0 && $booking->tax_amount !== null)
                            $vatLabel = "VAT (Intl. 0%)";
                        elseif ($rate == 0.05)
                            $vatLabel = "VAT (DTP 5%)";
                    @endphp
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Base Fare</span>
                            <span class="font-medium">${{ number_format($basePrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ $vatLabel }}</span>
                            <span class="font-medium">${{ number_format($vat, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Admin Fee</span>
                            <span class="font-medium">$1.00</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Paid</span>
                            <span class="font-bold text-primary-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-red-50 border-red-200">
                <div class="card-body">
                    <h4 class="text-red-800 font-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone</h4>
                    <p class="text-sm text-red-700 mb-4">Cancelling this booking will permanently remove it from the system
                        and free up the seat.</p>
                    <form action="{{ route('admin.bookings.destroy', $booking->confirmation_code) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-danger"
                            onclick="return confirm('Are you absolutely sure you want to cancel this booking?')">
                            <i class="fas fa-trash mr-2"></i>Cancel Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection