<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Passenger Details - AirlineBooking</title>
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
        <div class="container mx-auto px-6 max-w-5xl">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span class="ml-2 text-sm font-semibold text-gray-900">Search</span>
                        </div>
                        <div class="w-16 h-0.5 bg-primary-500 mx-4"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                2
                            </div>
                            <span class="ml-2 text-sm font-semibold text-primary-600">Details</span>
                        </div>
                        <div class="w-16 h-0.5 bg-gray-300 mx-4"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-semibold">
                                3
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Seats</span>
                        </div>
                        <div class="w-16 h-0.5 bg-gray-300 mx-4"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-semibold">
                                4
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Pay</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Details Card -->
                    <div class="card">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-address-book text-primary-500 mr-3"></i>Contact Details
                        </h2>

                        <div class="p-4 bg-primary-50 rounded-lg mb-6 border border-primary-100 flex items-start gap-3">
                            <i class="fas fa-info-circle text-primary-500 mt-1"></i>
                            <div class="text-sm text-gray-700">
                                E-ticket and other flight information will be sent to the email address below.
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label class="label">Full Name</label>
                                <input type="text" class="input" placeholder="As on ID Card/Passport/Driving License">
                            </div>
                            <div class="input-group">
                                <label class="label">Email Address</label>
                                <input type="email" class="input" placeholder="example@email.com">
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="label">Mobile Number</label>
                            <input type="text" inputmode="numeric" class="input" placeholder="81234567890"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>

                    <!-- Passenger Details Card -->
                    <div class="card">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user text-primary-500 mr-3"></i>Passenger Details
                        </h2>

                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="flight_call" value="{{ $flight->flight_call }}">

                            <!-- Toggle Logic could be added here for "Same as contact" -->
                            <div class="flex items-center mb-6">
                                <input type="checkbox" id="sameAsContact"
                                    class="w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                <label for="sameAsContact" class="ml-2 text-sm text-gray-700">Same as contact
                                    details</label>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="input-group">
                                    <label class="label">First Name *</label>
                                    <input type="text" name="first_name" maxlength="45" class="input" placeholder="John"
                                        required>
                                </div>
                                <div class="input-group">
                                    <label class="label">Last Name *</label>
                                    <input type="text" name="last_name" maxlength="45" class="input" placeholder="Doe"
                                        required>
                                </div>
                            </div>

                            <div class="input-group mb-6">
                                <label class="label">Middle Name (Optional)</label>
                                <input type="text" name="middle_name" maxlength="45" class="input"
                                    placeholder="Michael">
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="input-group">
                                    <label class="label">Email Address *</label>
                                    <input type="email" name="email" maxlength="45" class="input"
                                        placeholder="john.doe@example.com" required>
                                </div>
                                <div class="input-group">
                                    <label class="label">Phone Number *</label>
                                    <input type="text" name="phone" maxlength="45" class="input" inputmode="numeric"
                                        placeholder="12345678900" required
                                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="input-group">
                                    <label class="label">Passport Number *</label>
                                    <input type="text" name="passport" maxlength="45" class="input"
                                        placeholder="X12345678" required>
                                </div>
                                <div class="input-group">
                                    <label class="label">Nationality *</label>
                                    <select name="iata_country_code" class="input z-20" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->iata_country_code }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit"
                                    class="btn-primary w-full text-lg py-4 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                    Continue to Seat Selection
                                    <i class="fas fa-couch ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Flight Summary -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Flight Summary</h3>

                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-plane-departure text-primary-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $flight->schedule->originAirport->city }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $flight->schedule->originAirport->name }}
                                    </div>
                                    <div class="text-sm font-medium text-primary-600 mt-1">
                                        {{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}
                                    </div>
                                </div>
                            </div>

                            <div class="pl-5 border-l-2 border-dashed border-gray-300 ml-5 py-2">
                                <div class="text-xs text-gray-400 pl-4">Direct Flight</div>
                            </div>

                            <div class="flex items-start gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-plane-arrival text-secondary-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $flight->schedule->destinationAirport->city }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $flight->schedule->destinationAirport->name }}
                                    </div>
                                    <div class="text-sm font-medium text-primary-600 mt-1">
                                        {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>