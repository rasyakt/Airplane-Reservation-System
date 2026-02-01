<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Payment - AirlineBooking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-xl w-full mx-auto px-6">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-plane text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">AirlineBooking</h1>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Secure Payment</h2>
            <p class="text-gray-500 mt-2">Simulated payment gateway for development</p>
        </div>

        <!-- Payment Card -->
        <div class="card shadow-strong">
            <div class="mb-8 border-b border-gray-100 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Amount</h3>
                        <div class="text-4xl font-bold text-primary-600">
                            ${{ number_format($booking->total_price ?? ($booking->seat->flightSeatPrices->where('flight_call', $booking->flight_call)->first()->price_usd * 1.11 + 1), 2) }}
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="badge-info text-xs px-3 py-1">Order #{{ $booking->confirmation_code }}</span>
                    </div>
                </div>

                @php
                    $total = $booking->total_price ?? ($booking->seat->flightSeatPrices->where('flight_call', $booking->flight_call)->first()->price_usd * 1.11 + 1);
                    $price = $booking->seat->flightSeatPrices->where('flight_call', $booking->flight_call)->first()->price_usd;

                    // Recalculate if not stored (Legacy support)
                    if ($booking->tax_amount !== null) {
                        $vat = $booking->tax_amount;
                        // Infer rate for label
                        $rate = ($price > 0) ? round($vat / $price, 2) : 0;
                    } else {
                        // Advanced Calculation Fallback
                        $originCountry = trim($booking->flight->schedule->originAirport->iata_country_code);
                        $destCountry = trim($booking->flight->schedule->destinationAirport->iata_country_code);
                        $flightDate = $booking->flight->schedule->departure_time_gmt;

                        $isDomestic = ($originCountry == 'ID' && $destCountry == 'ID');
                        $isInternational = ($originCountry !== $destCountry);
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

                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Base Fare</span>
                        <span class="font-medium">${{ number_format($basePrice, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ $vatLabel }}</span>
                        <span class="font-medium">${{ number_format($vat, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>App Admin Fee</span>
                        <span class="font-medium">$1.00</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('bookings.payment.process', $booking->confirmation_code) }}" method="POST">
                @csrf
                <!-- Payment Methods -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_method" value="credit_card" class="peer sr-only" checked>
                        <div
                            class="flex flex-col items-center justify-center gap-2 p-4 border-2 border-gray-100 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all">
                            <i class="fas fa-credit-card text-2xl text-gray-400 peer-checked:text-primary-600"></i>
                            <span class="text-sm font-semibold text-gray-600">Credit Card</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only">
                        <div
                            class="flex flex-col items-center justify-center gap-2 p-4 border-2 border-gray-100 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all">
                            <i class="fas fa-university text-2xl text-gray-400 peer-checked:text-primary-600"></i>
                            <span class="text-sm font-semibold text-gray-600">Bank Transfer</span>
                        </div>
                    </label>
                </div>

                <!-- Simulation Info -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 flex gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm text-blue-800 font-medium">Payment Simulation</p>
                        <p class="text-xs text-blue-700 leading-relaxed mt-1">This is a dummy payment step. Clicking
                            "Pay Now" will simulate a successful transaction and confirm your booking.</p>
                    </div>
                </div>

                <!-- Hidden Booking Data -->
                <input type="hidden" name="booking_code" value="{{ $booking->confirmation_code }}">

                <button type="submit" class="btn-primary w-full py-4 text-lg shadow-glow">
                    Pay Now & Confirm Booking
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-lock mr-1"></i> SSL Encrypted & Secure
                </p>
                <div class="flex justify-center gap-4 mt-4 opacity-30 grayscale">
                    <i class="fab fa-cc-visa text-2xl"></i>
                    <i class="fab fa-cc-mastercard text-2xl"></i>
                    <i class="fab fa-cc-amex text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-400 text-sm">
            <a href="{{ route('home') }}" class="hover:text-primary-600">Cancel and Return</a>
        </div>
    </div>
</body>

</html>