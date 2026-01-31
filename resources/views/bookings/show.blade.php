<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flight Details - Airplane Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-100">
    <nav class="bg-gray-800 border-b border-gray-700 px-8 py-4">
        <div class="container mx-auto">
            <a href="{{ route('home') }}" class="text-2xl font-bold">✈️ Airplane Reservation</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Flight Info -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h1 class="text-3xl font-bold mb-6">Flight {{ $flight->flight_call }}</h1>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-gray-400 mb-1">From</div>
                    <div class="text-2xl font-semibold">{{ $flight->schedule->originAirport->city }}</div>
                    <div class="text-gray-400">{{ $flight->schedule->originAirport->name }}</div>
                    <div class="mt-2 text-lg">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }} GMT
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-1">To</div>
                    <div class="text-2xl font-semibold">{{ $flight->schedule->destinationAirport->city }}</div>
                    <div class="text-gray-400">{{ $flight->schedule->destinationAirport->name }}</div>
                    <div class="mt-2 text-lg">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }} GMT
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Selection -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6">Select Your Seat</h2>

            @if ($availableSeats->isEmpty())
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">😔</div>
                    <p class="text-xl text-gray-400">Sorry, all seats are fully booked for this flight.</p>
                </div>
            @else
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($availableSeats->groupBy('seat.travel_class_id') as $classId => $seats)
                        @php $travelClass = $seats->first()->seat->travelClass; @endphp
                        <div class="border border-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $travelClass->name }}</h3>
                            <p class="text-sm text-gray-400 mb-4">{{ $travelClass->description }}</p>
                            <div class="space-y-2">
                                @foreach ($seats->take(5) as $seatPrice)
                                    <button
                                        onclick="selectSeat({{ $seatPrice->seat_id }}, {{ $seatPrice->price_usd }}, '{{ $travelClass->name }}')"
                                        class="w-full px-4 py-3 bg-gray-700 hover:bg-blue-600 rounded-lg text-left transition">
                                        <div class="flex justify-between items-center">
                                            <span>Seat {{ $seatPrice->seat_id }}</span>
                                            <span class="font-semibold">${{ number_format($seatPrice->price_usd, 2) }}</span>
                                        </div>
                                    </button>
                                @endforeach
                                @if ($seats->count() > 5)
                                    <p class="text-sm text-gray-400 text-center">+{{ $seats->count() - 5 }} more seats</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function selectSeat(seatId, price, className) {
            if (confirm(`Book ${className} seat #${seatId} for $${price.toFixed(2)}?`)) {
                // Store selection and redirect to client form
                sessionStorage.setItem('selectedSeat', JSON.stringify({
                    flight_call: '{{ $flight->flight_call }}',
                    seat_id: seatId,
                    aircraft_id: {{ $flight->flightSeatPrices->first()->aircraft_id ?? 0 }},
                    price: price,
                    class: className
                }));
                window.location.href = '{{ route("clients.create") }}';
            }
        }
    </script>
</body>

</html>