<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Seat - AirlineBooking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-soft sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plane text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">AirlineBooking</h1>
            </a>
        </div>
    </nav>

    <div class="bg-background min-h-screen py-8">
        <div class="container mx-auto px-6 max-w-7xl">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="ml-3 text-sm font-semibold text-gray-900">Select Flight</span>
                        </div>
                        <div class="w-24 h-0.5 bg-primary-500 mx-4"></div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">2</div>
                            <span class="ml-3 text-sm font-semibold text-primary-600">Choose Seat</span>
                        </div>
                        <div class="w-24 h-0.5 bg-gray-300 mx-4"></div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold">3</div>
                            <span class="ml-3 text-sm font-medium text-gray-500">Passenger Info</span>
                        </div>
                        <div class="w-24 h-0.5 bg-gray-300 mx-4"></div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold">4</div>
                            <span class="ml-3 text-sm font-medium text-gray-500">Confirmation</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Flight Summary -->
                    <div class="card mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-900">Flight {{ $flight->flight_call }}</h2>
                            <span class="badge-success"><i class="fas fa-check-circle mr-1"></i>Available</span>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                            <div>
                                <div class="text-sm text-gray-500 mb-1"><i class="fas fa-plane-departure mr-2"></i>Departure</div>
                                <div class="text-xl font-semibold">{{ $flight->schedule->originAirport->city }}</div>
                                <div class="text-gray-600">{{ $flight->schedule->originAirport->name }}</div>
                                <div class="text-lg font-medium text-primary-600 mt-2">
                                    {{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }} GMT
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1"><i class="fas fa-plane-arrival mr-2"></i>Arrival</div>
                                <div class="text-xl font-semibold">{{ $flight->schedule->destinationAirport->city }}</div>
                                <div class="text-gray-600">{{ $flight->schedule->destinationAirport->name }}</div>
                                <div class="text-lg font-medium text-primary-600 mt-2">
                                    {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }} GMT
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Selection -->
                    <div class="card">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-chair text-primary-500 mr-2"></i>Select Your Seat
                        </h3>
                        
                        @if ($availableSeats->isEmpty())
                            <div class="text-center py-16">
                                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
                                </div>
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">Fully Booked</h4>
                                <p class="text-gray-600 mb-6">Sorry, all seats are taken for this flight.</p>
                                <a href="{{ route('flights.search') }}" class="btn-primary">
                                    <i class="fas fa-search"></i>Find Another Flight
                                </a>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach ($availableSeats->groupBy('seat.travel_class_id') as $classId => $seats)
                                    @php $travelClass = $seats->first()->seat->travelClass; @endphp
                                    <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-primary-300 transition">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-3">
                                                @if ($travelClass->name == 'First Class')
                                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-crown text-white text-xl"></i>
                                                    </div>
                                                @elseif ($travelClass->name == 'Business')
                                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-briefcase text-white text-xl"></i>
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-chair text-white text-xl"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="text-xl font-bold text-gray-900">{{ $travelClass->name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $travelClass->description }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500">{{ $seats->count() }} seats available</div>
                                            </div>
                                        </div>

                                        <!-- Seat Options -->
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                            @foreach ($seats->take(12) as $seatPrice)
                                                <button onclick="selectSeat({{ $seatPrice->seat_id }}, {{ $seatPrice->price_usd }}, '{{ $travelClass->name }}')" 
                                                        class="group relative p-4 bg-white border-2 border-gray-200 rounded-lg hover:border-primary-500 hover:shadow-md transition-all">
                                                    <div class="text-center">
                                                        <i class="fas fa-couch text-2xl text-gray-400 group-hover:text-primary-500 mb-2"></i>
                                                        <div class="text-sm font-semibold text-gray-700">{{ $seatPrice->seat_id }}</div>
                                                        <div class="text-lg font-bold text-primary-600 mt-1">${{ number_format($seatPrice->price_usd, 0) }}</div>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                        
                                        @if ($seats->count() > 12)
                                            <div class="mt-4 text-center">
                                                <button class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                                                    Show {{ $seats->count() - 12 }} more seats <i class="fas fa-chevron-down ml-1"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Booking Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Booking Summary</h3>
                        <div class="space-y-4">
                            <div class="pb-4 border-b border-gray-200">
                                <div class="text-sm text-gray-500 mb-1">Route</div>
                                <div class="font-semibold text-gray-900">
                                    {{ $flight->schedule->originAirport->iata_airport_code }} 
                                    <i class="fas fa-arrow-right text-primary-500 mx-2"></i>
                                    {{ $flight->schedule->destinationAirport->iata_airport_code }}
                                </div>
                            </div>

                            <div id="selectedSeatInfo" class="hidden pb-4 border-b border-gray-200">
                                <div class="text-sm text-gray-500 mb-1">Selected Seat</div>
                                <div class="font-semibold text-gray-900"><span id="seatNumber">-</span></div>
                                <div class="text-sm text-gray-600"><span id="seatClass">-</span></div>
                            </div>

                            <div id="priceInfo" class="hidden">
                                <div class="flex justify-between text-gray-600 mb-2">
                                    <span>Base Price</span>
                                    <span>$<span id="basePrice">0</span></span>
                                </div>
                                <div class="flex justify-between text-gray-600 mb-2">
                                    <span id="vatLabel">VAT (11%)</span>
                                    <span>$<span id="vatPrice">0</span></span>
                                </div>
                                <div class="flex justify-between text-gray-600 mb-2">
                                    <span>Admin Fee</span>
                                    <span>$1.00</span>
                                </div>
                                <div class="flex justify-between font-bold text-xl text-gray-900 pt-4 border-t-2 border-gray-200">
                                    <span>Total</span>
                                    <span class="text-primary-600">$<span id="totalPrice">0</span></span>
                                </div>
                            </div>

                            <div id="noSelection" class="text-center py-8 text-gray-400">
                                <i class="fas fa-hand-pointer text-4xl mb-3"></i>
                                <p class="text-sm">Select a seat to continue</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectSeat(seatId, price, className) {
            // Update summary
            document.getElementById('noSelection').classList.add('hidden');
            document.getElementById('selectedSeatInfo').classList.remove('hidden');
            document.getElementById('priceInfo').classList.remove('hidden');
            
            // Tax Logic
            const originCountry = '{{ $flight->schedule->originAirport->iata_country_code }}';
            const destCountry = '{{ $flight->schedule->destinationAirport->iata_country_code }}';
            const flightDate = new Date('{{ $flight->schedule->departure_time_gmt }}');
            
            const dtpStart = new Date('2025-10-22');
            const dtpEnd = new Date('2026-01-10');
            
            let taxRate = 0.11; // Default Domestic
            let taxLabel = 'VAT (11%)';

            const isDomestic = (originCountry === 'ID' && destCountry === 'ID');
            const isInternational = !isDomestic;
            const isDtpPeriod = (flightDate >= dtpStart && flightDate <= dtpEnd);

            if (isInternational) {
                taxRate = 0;
                taxLabel = 'VAT (Intl. 0%)';
            } else if (isDtpPeriod) {
                taxRate = 0.05;
                taxLabel = 'VAT (DTP 5%)';
            }

            var vat = price * taxRate;
            var adminFee = 1.00;
            var total = price + vat + adminFee;

            document.getElementById('seatNumber').textContent = 'Seat #' + seatId;
            document.getElementById('seatClass').textContent = className;
            document.getElementById('basePrice').textContent = price.toFixed(2);
            document.getElementById('vatLabel').textContent = taxLabel;
            document.getElementById('vatPrice').textContent = vat.toFixed(2);
            document.getElementById('totalPrice').textContent = total.toFixed(2);

            // Store and redirect
            sessionStorage.setItem('selectedSeat', JSON.stringify({
                flight_call: '{{ $flight->flight_call }}',
                seat_id: seatId,
                aircraft_id: {{ $flight->flightSeatPrices->first()->aircraft_id ?? 0 }},
                price: price,
                class: className
            }));
            
            setTimeout(() => {
                window.location.href = '{{ route("clients.create") }}';
            }, 500);
        }
    </script>
</body>
</html>