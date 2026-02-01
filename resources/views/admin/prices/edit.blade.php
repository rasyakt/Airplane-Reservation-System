@extends('layouts.admin')

@section('title', 'Set Prices - Flight ' . $flight->flight_call)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.prices.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Back to Pricing
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-dollar-sign text-primary-500 mr-2"></i>Set Class Pricing
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.prices.update', $flight->flight_call) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            @foreach ($travelClasses as $class)
                                @php
                                    $existingPrice = $existingPrices->where('seat.travel_class_id', $class->travel_class_id)->first();
                                @endphp
                                <div class="p-4 border border-gray-100 rounded-xl bg-gray-50">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600">
                                                @if($class->name == 'First Class') <i class="fas fa-crown"></i>
                                                @elseif($class->name == 'Business') <i class="fas fa-briefcase"></i>
                                                @else <i class="fas fa-chair"></i> @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $class->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $class->description }}</p>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $flight->aircraftInstances->first()?->aircraft->seats->where('travel_class_id', $class->travel_class_id)->count() ?? 0 }}
                                            seats
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="prices[{{ $class->travel_class_id }}]" step="0.01" min="0"
                                            class="input pl-7" placeholder="0.00"
                                            value="{{ $existingPrice ? $existingPrice->price_usd : '' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="btn-primary w-full py-4 text-lg">
                                <i class="fas fa-check-circle mr-2"></i>Apply Pricing to All Seats
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">Flight Info</div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-gray-500 uppercase font-semibold">Route</div>
                            <div class="text-sm font-bold">{{ $flight->schedule->originAirport->city }} →
                                {{ $flight->schedule->destinationAirport->city }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase font-semibold">Scheduled Time</div>
                            <div class="text-sm">
                                {{ date('M j, Y - H:i', strtotime($flight->schedule->departure_time_gmt)) }} GMT</div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 italic text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Prices will be applied to all available and unavailable
                            seats for this specific flight schedule.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection