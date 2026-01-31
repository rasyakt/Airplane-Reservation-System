<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Passenger Information - Airplane Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-100">
    <nav class="bg-gray-800 border-b border-gray-700 px-8 py-4">
        <div class="container mx-auto">
            <a href="{{ route('home') }}" class="text-2xl font-bold">✈️ Airplane Reservation</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold mb-8">Passenger Information</h1>

        <form id="clientForm" class="bg-gray-800 rounded-lg p-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2">First Name *</label>
                    <input type="text" name="first_name" maxlength="45"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Last Name *</label>
                    <input type="text" name="last_name" maxlength="45"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Middle Name (Optional)</label>
                <input type="text" name="middle_name" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Email Address *</label>
                <input type="email" name="email" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
                <p id="emailError" class="text-red-400 text-sm mt-1 hidden"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Phone Number *</label>
                <input type="tel" name="phone" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Passport Number *</label>
                <input type="text" name="passport" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Nationality *</label>
                <select name="iata_country_code"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->iata_country_code }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="bookingSummary" class="bg-gray-700 rounded-lg p-4 mb-6 hidden">
                <h3 class="font-semibold mb-2">Booking Summary</h3>
                <div class="text-sm space-y-1 text-gray-300">
                    <div>Flight: <span id="summaryFlight"></span></div>
                    <div>Seat: <span id="summarySeat"></span></div>
                    <div>Class: <span id="summaryClass"></span></div>
                    <div class="text-lg font-semibold mt-2">Total: $<span id="summaryPrice"></span></div>
                </div>
            </div>

            <button type="submit"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800">
                Complete Booking
            </button>
        </form>
    </div>

    <script>
        // Load booking summary from session
        const seatData = JSON.parse(sessionStorage.getItem('selectedSeat') || '{}');
        if (seatData.seat_id) {
            document.getElementById('bookingSummary').classList.remove('hidden');
            document.getElementById('summaryFlight').textContent = seatData.flight_call;
            document.getElementById('summarySeat').textContent = '#' + seatData.seat_id;
            document.getElementById('summaryClass').textContent = seatData.class;
            document.getElementById('summaryPrice').textContent = seatData.price.toFixed(2);
        }

        // Form submission
        document.getElementById('clientForm').addEventListener('submit', async function (e) {
            e.preventDefault();

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
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>
</body>

</html>