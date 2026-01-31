<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Passenger Information - AirlineBooking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-soft sticky top-0 z-50">
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

    <div class="bg-background min-h-screen py-8">
        <div class="container mx-auto px-6 max-w-4xl">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <div class="w-20 h-0.5 bg-primary-500 mx-2"></div>
                        <div
                            class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <div class="w-20 h-0.5 bg-primary-500 mx-2"></div>
                        <div
                            class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            3</div>
                        <div class="w-20 h-0.5 bg-gray-300 mx-2"></div>
                        <div
                            class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-semibold">
                            4</div>
                    </div>
                </div>
                <div class="flex justify-center mt-3">
                    <span class="text-sm font-semibold text-primary-600">Passenger Information</span>
                </div>
            </div>

            <!-- Main Form -->
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="card">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-user-circle text-primary-500 mr-2"></i>Enter Passenger Details
                        </h2>

                        <form id="clientForm">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="input-group">
                                    <label class="label"><i class="fas fa-user mr-2"></i>First Name *</label>
                                    <input type="text" name="first_name" maxlength="45" class="input" placeholder="John"
                                        required>
                                </div>
                                <div class="input-group">
                                    <label class="label"><i class="fas fa-user mr-2"></i>Last Name *</label>
                                    <input type="text" name="last_name" maxlength="45" class="input" placeholder="Doe"
                                        required>
                                </div>
                            </div>

                            <div class="input-group mb-6">
                                <label class="label"><i class="fas fa-user mr-2"></i>Middle Name (Optional)</label>
                                <input type="text" name="middle_name" maxlength="45" class="input"
                                    placeholder="Michael">
                            </div>

                            <div class="input-group mb-6">
                                <label class="label"><i class="fas fa-envelope mr-2"></i>Email Address *</label>
                                <input type="email" name="email" maxlength="45" class="input"
                                    placeholder="john.doe@example.com" required>
                                <p id="emailError" class="text-red-500 text-sm mt-1 hidden"></p>
                            </div>

                            <div class="input-group mb-6">
                                <label class="label"><i class="fas fa-phone mr-2"></i>Phone Number *</label>
                                <input type="tel" name="phone" maxlength="45" class="input"
                                    placeholder="+1 234 567 8900" required>
                            </div>

                            <div class="input-group mb-6">
                                <label class="label"><i class="fas fa-passport mr-2"></i>Passport Number *</label>
                                <input type="text" name="passport" maxlength="45" class="input" placeholder="X12345678"
                                    required>
                            </div>

                            <div class="input-group mb-8">
                                <label class="label"><i class="fas fa-flag mr-2"></i>Nationality *</label>
                                <select name="iata_country_code" class="input" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->iata_country_code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn-success w-full text-lg py-4">
                                <i class="fas fa-check-circle mr-2"></i>Complete Booking
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Booking Summary</h3>

                        <div id="summaryContent" class="space-y-4 hidden">
                            <div class="pb-4 border-b border-gray-200">
                                <div class="text-xs text-gray-500 mb-1">Flight</div>
                                <div class="font-semibold text-gray-900 text-sm" id="summaryFlight">-</div>
                            </div>

                            <div class="pb-4 border-b border-gray-200">
                                <div class="text-xs text-gray-500 mb-1">Seat</div>
                                <div class="font-semibold text-gray-900 text-sm" id="summarySeat">-</div>
                                <div class="text-xs text-gray-600 mt-1" id="summaryClass">-</div>
                            </div>

                            <div class="bg-primary-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-700">Total Amount</span>
                                    <span class="text-2xl font-bold text-primary-600">$<span
                                            id="summaryPrice">0</span></span>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-start gap-2 text-xs text-blue-700">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <span>You'll receive a confirmation email after booking</span>
                                </div>
                            </div>
                        </div>

                        <div id="noBooking" class="text-center py-8">
                            <i class="fas fa-ticket-alt text-4xl text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-400">No booking selected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load booking summary
        const seatData = JSON.parse(sessionStorage.getItem('selectedSeat') || '{}');
        if (seatData.seat_id) {
            document.getElementById('noBooking').classList.add('hidden');
            document.getElementById('summaryContent').classList.remove('hidden');
            document.getElementById('summaryFlight').textContent = seatData.flight_call;
            document.getElementById('summarySeat').textContent = 'Seat #' + seatData.seat_id;
            document.getElementById('summaryClass').textContent = seatData.class;
            document.getElementById('summaryPrice').textContent = seatData.price.toFixed(2);
        }

        // Form submission
        document.getElementById('clientForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                // Register client
                const response = await fetch('{{ route("clients.register") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    // Create booking
                    const bookingResponse = await fetch('{{ route("bookings.confirm") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            client_id: result.client_id,
                            flight_call: seatData.flight_call,
                            aircraft_id: seatData.aircraft_id,
                            seat_id: seatData.seat_id
                        })
                    });

                    if (bookingResponse.ok) {
                        sessionStorage.removeItem('selectedSeat');
                        window.location.href = bookingResponse.url;
                    }
                } else {
                    alert('Registration failed. Please check your information.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Complete Booking';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Complete Booking';
            }
        });
    </script>
</body>

</html>