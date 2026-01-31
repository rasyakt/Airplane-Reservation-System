<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed - Airplane Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-100">
    <nav class="bg-gray-800 border-b border-gray-700 px-8 py-4">
        <div class="container mx-auto">
            <a href="{{ route('home') }}" class="text-2xl font-bold">✈️ Airplane Reservation</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <div class="text-center mb-8">
            <div class="text-8xl mb-4">✅</div>
            <h1 class="text-4xl font-bold mb-2">Booking Confirmed!</h1>
            <p class="text-xl text-gray-400">Your flight has been successfully booked</p>
        </div>

        <div class="bg-gray-800 rounded-2xl p-8 mb-6">
            <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-700">
                <div>
                    <div class="text-sm text-gray-400">Confirmation Code</div>
                    <div class="text-3xl font-bold text-green-400">{{ $booking->confirmation_code }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-400">Payment Status</div>
                    <div
                        class="px-4 py-2 rounded-lg {{ $booking->payment_status == 'paid' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">
                        {{ ucfirst($booking->payment_status) }}
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Flight Details</h2>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <div class="text-sm text-gray-400 mb-1">From</div>
                    <div class="text-xl font-semibold">{{ $booking->flight->schedule->originAirport->city }}</div>
                    <div class="text-gray-400">{{ $booking->flight->schedule->originAirport->name }}</div>
                    <div class="mt-2">
                        {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->departure_time_gmt)) }} GMT</div>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-1">To</div>
                    <div class="text-xl font-semibold">{{ $booking->flight->schedule->destinationAirport->city }}</div>
                    <div class="text-gray-400">{{ $booking->flight->schedule->destinationAirport->name }}</div>
                    <div class="mt-2">
                        {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->arrival_time_gmt)) }} GMT</div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6">
                <h3 class="text-xl font-semibold mb-4">Passenger Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-400">Name</div>
                        <div class="font-semibold" {{ $booking->client->full_name }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400">Email</div>
                            <div>{{ $booking->client->email }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400">Phone</div>
                            <div>{{ $booking->client->phone }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400">Passport</div>
                            <div>{{ $booking->client->passport }}</div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-6 mt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-400">Seat</div>
                            <div class="text-2xl font-semibold">{{ $booking->seat->travelClass->name }} -
                                #{{ $booking->seat_id }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Flight Number</div>
                            <div class="text-2xl font-semibold">{{ $booking->flight_call }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-900 border border-blue-700 rounded-lg p-6 mb-6">
                <h3 class="font-semibold mb-2">📧 Confirmation Email Sent</h3>
                <p class="text-sm text-blue-200">A confirmation email with your boarding pass has been sent to
                    <strong>{{ $booking->client->email }}</strong></p>
            </div>

            <div class="flex gap-4">
                <button onclick="window.print()" class="flex-1 px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg">
                    🖨️ Print Confirmation
                </button>
                <a href="{{ route('home') }}"
                    class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-center">
                    ← Book Another Flight
                </a>
            </div>
        </div>
</body>

</html>