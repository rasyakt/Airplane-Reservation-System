<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed - AirlineBooking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(0deg);
            }

            50% {
                transform: scale(1.2) rotate(180deg);
            }

            100% {
                transform: scale(1) rotate(360deg);
            }
        }

        .animate-checkmark {
            animation: checkmark 0.6s ease-out;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-soft sticky top-0 z-50 no-print">
        <div class="container mx-auto px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plane text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">AirlineBooking</h1>
            </a>
        </div>
    </nav>

    <div class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen py-12">
        <div class="container mx-auto px-6 max-w-4xl">
            <!-- Success Message -->
            <div class="text-center mb-8 no-print">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-success-500 to-success-600 rounded-full flex items-center justify-center mx-auto mb-6 animate-checkmark shadow-glow">
                    <i class="fas fa-check text-white text-5xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Booking Confirmed!</h1>
                <p class="text-xl text-gray-600">Your flight has been successfully booked</p>
            </div>

            <!-- Confirmation Card -->
            <div class="card mb-6">
                <!-- Confirmation Code -->
                <div
                    class="bg-gradient-to-r from-primary-500 to-primary-700 -mx-6 -mt-6 p-8 rounded-t-card mb-6 text-white">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <div class="text-sm opacity-90 mb-2">Confirmation Code</div>
                            <div class="text-4xl font-bold tracking-wider">{{ $booking->confirmation_code }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm opacity-90 mb-2">Payment Status</div>
                            <div
                                class="inline-block px-4 py-2 {{ $booking->payment_status == 'paid' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-lg font-semibold">
                                {{ ucfirst($booking->payment_status) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flight Details -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-plane-departure text-primary-500 mr-2"></i>Flight Details
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-lg">
                        <div>
                            <div class="text-sm text-gray-500 mb-2">Departure</div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $booking->flight->schedule->originAirport->city }}</div>
                            <div class="text-gray-600 mb-2">{{ $booking->flight->schedule->originAirport->name }}</div>
                            <div class="flex items-center gap-2 text-primary-600 font-semibold">
                                <i class="far fa-clock"></i>
                                {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->departure_time_gmt)) }}
                                GMT
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-2">Arrival</div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $booking->flight->schedule->destinationAirport->city }}</div>
                            <div class="text-gray-600 mb-2">{{ $booking->flight->schedule->destinationAirport->name }}
                            </div>
                            <div class="flex items-center gap-2 text-primary-600 font-semibold">
                                <i class="far fa-clock"></i>
                                {{ date('F j, Y - H:i', strtotime($booking->flight->schedule->arrival_time_gmt)) }} GMT
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Info -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-user text-primary-500 mr-2"></i>Passenger Information
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg">
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
                            <div class="text-sm text-gray-500 mb-1">Passport</div>
                            <div class="font-semibold text-gray-900">{{ $booking->client->passport }}</div>
                        </div>
                    </div>
                </div>

                <!-- Seat & Flight Info -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="grid md:grid-cols-3 gap-6 text-center">
                        <div class="p-4 bg-primary-50 rounded-lg">
                            <div class="text-sm text-gray-600 mb-2">Flight Number</div>
                            <div class="text-2xl font-bold text-primary-600">{{ $booking->flight_call }}</div>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <div class="text-sm text-gray-600 mb-2">Class</div>
                            <div class="text-2xl font-bold text-purple-600">{{ $booking->seat->travelClass->name }}
                            </div>
                        </div>
                        <div class="p-4 bg-secondary-50 rounded-lg">
                            <div class="text-sm text-gray-600 mb-2">Seat Number</div>
                            <div class="text-2xl font-bold text-secondary-600">#{{ $booking->seat_id }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Notification -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6 no-print">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Confirmation Email Sent</h3>
                        <p class="text-gray-700">A confirmation email with your boarding pass has been sent to
                            <strong>{{ $booking->client->email }}</strong>. Please check your inbox.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid md:grid-cols-2 gap-4 no-print">
                <button onclick="window.print()"
                    class="btn bg-white text-gray-700 border-2 border-gray-300 hover:bg-gray-50">
                    <i class="fas fa-print"></i>Print Boarding Pass
                </button>
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fas fa-home"></i>Back to Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>