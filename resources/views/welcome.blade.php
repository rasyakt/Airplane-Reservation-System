<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airplane Reservation - Book Your Flight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-soft sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plane text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">AirlineBooking</h1>
                        <p class="text-xs text-gray-500">Your Journey Starts Here</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-700 hover:text-primary-600 font-medium transition">
                            <i class="fas fa-user-circle mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-primary-600 font-medium transition">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 py-20 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-5xl md:text-6xl font-bold text-white mb-4 animate-fade-in">
                    Find Your Perfect Flight
                </h2>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Search and book flights to destinations worldwide at the best prices
                </p>
            </div>

            <!-- Search Card -->
            <div class="max-w-5xl mx-auto">
                <form action="{{ route('flights.search') }}" method="GET"
                    class="bg-white rounded-2xl shadow-strong p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Origin -->
                        <div class="input-group">
                            <label class="label">
                                <i class="fas fa-plane-departure text-primary-500 mr-2"></i>From
                            </label>
                            <select name="origin" class="input" required>
                                <option value="">Select Origin</option>
                                @foreach ($airports as $airport)
                                    <option value="{{ $airport->iata_airport_code }}">
                                        {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Destination -->
                        <div class="input-group">
                            <label class="label">
                                <i class="fas fa-plane-arrival text-secondary-500 mr-2"></i>To
                            </label>
                            <select name="destination" class="input" required>
                                <option value="">Select Destination</option>
                                @foreach ($airports as $airport)
                                    <option value="{{ $airport->iata_airport_code }}">
                                        {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="input-group">
                            <label class="label">
                                <i class="fas fa-calendar text-success-500 mr-2"></i>Departure Date
                            </label>
                            <input type="date" name="departure_date" class="input" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full mt-6 text-lg py-4 shadow-glow">
                        <i class="fas fa-search mr-2"></i>Search Flights
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Popular Destinations -->
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-900 mb-3">Popular Destinations</h3>
            <p class="text-gray-600">Explore trending routes and best deals</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            @foreach ($airports->take(5) as $airport)
                <div class="group cursor-pointer">
                    <div class="card hover:scale-105 transition-transform duration-300">
                        <!-- City Icon/Image -->
                        <div
                            class="w-full h-32 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-city text-5xl text-primary-500"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 text-lg mb-1">{{ $airport->city }}</h4>
                        <p class="text-sm text-gray-500 mb-2">{{ $airport->name }}</p>
                        <div class="flex justify-between items-center">
                            <span class="badge-primary">{{ $airport->iata_airport_code }}</span>
                            <span class="text-primary-600 font-semibold text-sm">View Flights →</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-3">Why Choose Us?</h3>
                <p class="text-gray-600">The best flight booking experience</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="card text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-3xl text-primary-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">Secure Booking</h4>
                    <p class="text-gray-600">Your payment and personal data are 100% protected with enterprise-grade
                        security</p>
                </div>

                <div class="card text-center">
                    <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tags text-3xl text-secondary-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">Best Prices</h4>
                    <p class="text-gray-600">Compare prices from multiple airlines and get the best deals guaranteed</p>
                </div>

                <div class="card text-center">
                    <div class="w-16 h-16 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-3xl text-success-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">24/7 Support</h4>
                    <p class="text-gray-600">Our customer service team is always ready to help you anytime, anywhere</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h5 class="text-white font-semibold mb-4">About Us</h5>
                    <p class="text-sm">Your trusted partner for flight bookings worldwide. We make travel easy and
                        affordable.</p>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-4">Support</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-4">Follow Us</h5>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} AirlineBooking. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>