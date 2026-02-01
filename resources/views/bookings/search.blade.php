<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - AirlineBooking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-soft sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plane text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">AirlineBooking</h1>
                    </div>
                </a>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-br from-primary-50 to-blue-50 min-h-screen py-8">
        <div class="container mx-auto px-6">
            <!-- Search Summary Card -->
            <div class="card mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Flight Search Results</h2>
                        <div class="flex items-center gap-4 text-gray-600">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-plane-departure text-primary-500"></i>
                                <strong>{{ $searchParams['origin'] }}</strong>
                            </span>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-plane-arrival text-secondary-500"></i>
                                <strong>{{ $searchParams['destination'] }}</strong>
                            </span>
                            <span class="text-gray-400">•</span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-calendar text-success-500"></i>
                                {{ date('F j, Y', strtotime($searchParams['departure_date'])) }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="btn-secondary">
                        <i class="fas fa-search"></i>New Search
                    </a>
                </div>
            </div>

            @if ($flights->isEmpty())
                <!-- Empty State -->
                <div class="card text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-plane-slash text-5xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Flights Found</h3>
                        <p class="text-gray-600 mb-8">We couldn't find any flights matching your search criteria. Try
                            adjusting your dates or destinations.</p>
                        <a href="{{ route('home') }}" class="btn-primary">
                            <i class="fas fa-arrow-left"></i>Search Again
                        </a>
                    </div>
                </div>
            @else
                <!-- Results Count -->
                <div class="mb-6">
                    <p class="text-gray-600">
                        <strong class="text-gray-900">{{ $flights->count() }}</strong> flights available
                    </p>
                </div>

                <!-- Flight Cards -->
                <div class="space-y-4">
                    @foreach ($flights as $flight)
                        <div class="card hover:scale-[1.01] transition-transform duration-200">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <!-- Flight Details -->
                                <div class="flex-1">
                                    <!-- Airline Header -->
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-plane text-primary-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">Flight {{ $flight->flight_call }}</div>
                                            <div class="text-sm text-gray-500">Standard Service</div>
                                        </div>
                                    </div>

                                    <!-- Timeline -->
                                    <div class="flex items-center gap-8">
                                        <!-- Departure -->
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900">
                                                {{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}
                                            </div>
                                            <div class="text-sm font-medium text-gray-600 mt-1">
                                                {{ $flight->schedule->originAirport->iata_airport_code }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $flight->schedule->originAirport->city }}
                                            </div>
                                        </div>

                                        <!-- Duration -->
                                        <div class="flex-1 flex flex-col items-center">
                                            <div class="text-xs text-gray-500 mb-1">
                                                @php
                                                    $departure = strtotime($flight->schedule->departure_time_gmt);
                                                    $arrival = strtotime($flight->schedule->arrival_time_gmt);
                                                    $duration = ($arrival - $departure) / 3600;
                                                @endphp
                                                {{ floor($duration) }}h {{ ($duration - floor($duration)) * 60 }}m
                                            </div>
                                            <div class="w-full flex items-center">
                                                <div class="h-0.5 bg-gray-300 flex-1"></div>
                                                <i class="fas fa-plane text-primary-500 mx-2 rotate-90"></i>
                                                <div class="h-0.5 bg-gray-300 flex-1"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">Direct</div>
                                        </div>

                                        <!-- Arrival -->
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900">
                                                {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}
                                            </div>
                                            <div class="text-sm font-medium text-gray-600 mt-1">
                                                {{ $flight->schedule->destinationAirport->iata_airport_code }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $flight->schedule->destinationAirport->city }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="mt-4">
                                        @if ($flight->status->name == 'Scheduled')
                                            <span class="badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>{{ $flight->status->name }}
                                            </span>
                                        @elseif ($flight->status->name == 'Delayed')
                                            <span class="badge-warning">
                                                <i class="fas fa-clock mr-1"></i>{{ $flight->status->name }}
                                            </span>
                                        @else
                                            <span class="badge-info">{{ $flight->status->name }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="text-center md:text-right md:pl-8 md:border-l border-gray-200">
                                    <div class="mb-4">
                                        <div class="text-sm text-gray-500 mb-1">Starting from</div>
                                        <div class="text-3xl font-bold text-primary-600">
                                            ${{ number_format($flight->min_price, 0) }}</div>
                                        <div class="text-xs text-gray-500">/person</div>
                                    </div>
                                    <a href="{{ route('clients.create', ['flight_call' => $flight->flight_call]) }}"
                                        class="btn-primary w-full">
                                        Select Flight
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>

</html>