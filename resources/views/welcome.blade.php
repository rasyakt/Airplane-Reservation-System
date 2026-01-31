<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airplane Reservation - Find Your Flight</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Hero Section -->
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gray-800 border-b border-gray-700 px-8 py-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">✈️ Airplane Reservation</h1>
                <div class="space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Search Form -->
        <div class="flex-1 flex items-center justify-center px-4">
            <div class="max-w-4xl w-full">
                <h2 class="text-4xl font-bold text-center mb-4">Find Your Perfect Flight</h2>
                <p class="text-center text-gray-400 mb-12">Search flights to destinations worldwide</p>

                <form action="{{ route('flights.search') }}" method="GET"
                    class="bg-gray-800 p-8 rounded-2xl shadow-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">From</label>
                            <select name="origin"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white"
                                required>
                                <option value="">Select Origin</option>
                                @foreach ($airports as $airport)
                                    <option value="{{ $airport->iata_airport_code }}">
                                        {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">To</label>
                            <select name="destination"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white"
                                required>
                                <option value="">Select Destination</option>
                                @foreach ($airports as $airport)
                                    <option value="{{ $airport->iata_airport_code }}">
                                        {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Departure Date</label>
                            <input type="date" name="departure_date"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white"
                                min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <br<button type="submit"
                        class="w-full mt-6 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-lg transform hover:scale-105 transition">
                        🔍 Search Flights
                        </button>
                </form>

                <!-- Popular Destinations -->
                <div class="mt-16">
                    <h3 class="text-2xl font-semibold text-center mb-8">Popular Destinations</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach ($airports->take(5) as $airport)
                            <div class="bg-gray-800 p-4 rounded-lg text-center hover:bg-gray-700 cursor-pointer">
                                <div class="text-3xl mb-2">🌍</div>
                                <div class="font-semibold">{{ $airport->city }}</div>
                                <div class="text-sm text-gray-400">{{ $airport->iata_airport_code }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>