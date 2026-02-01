@extends('layouts.admin')

@section('title', 'Create Schedule')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.schedules.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Add New Schedule</h2>
                <p class="text-gray-500 text-sm">Define a new flight route and timing.</p>
            </div>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Route Section -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-map-marked-alt text-primary-500 mr-2"></i>Route Information
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Origin -->
                            <div class="input-group">
                                <label class="label">Origin Airport</label>
                                <div class="relative">
                                    <i class="fas fa-plane-departure absolute left-4 top-4 text-gray-400"></i>
                                    <select name="origin_iata_airport_code"
                                        class="input pl-10 @error('origin_iata_airport_code') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Origin</option>
                                        @foreach ($airports as $airport)
                                            <option value="{{ $airport->iata_airport_code }}" {{ old('origin_iata_airport_code') == $airport->iata_airport_code ? 'selected' : '' }}>
                                                {{ $airport->city }} ({{ $airport->iata_airport_code }}) - {{ $airport->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('origin_iata_airport_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Destination -->
                            <div class="input-group">
                                <label class="label">Destination Airport</label>
                                <div class="relative">
                                    <i class="fas fa-plane-arrival absolute left-4 top-4 text-gray-400"></i>
                                    <select name="dest_iata_airport_code"
                                        class="input pl-10 @error('dest_iata_airport_code') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Destination</option>
                                        @foreach ($airports as $airport)
                                            <option value="{{ $airport->iata_airport_code }}" {{ old('dest_iata_airport_code') == $airport->iata_airport_code ? 'selected' : '' }}>
                                                {{ $airport->city }} ({{ $airport->iata_airport_code }}) - {{ $airport->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('dest_iata_airport_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 md:col-span-2 my-2"></div>

                    <!-- Timing Section -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>Timing (GMT)
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Departure Time -->
                            <div class="input-group">
                                <label class="label">Departure Time</label>
                                <div class="relative">
                                    <input type="datetime-local" name="departure_time_gmt"
                                        class="input @error('departure_time_gmt') border-red-500 @enderror"
                                        value="{{ old('departure_time_gmt') }}" required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Global Mean Time (GMT)</p>
                                @error('departure_time_gmt')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Arrival Time -->
                            <div class="input-group">
                                <label class="label">Arrival Time</label>
                                <div class="relative">
                                    <input type="datetime-local" name="arrival_time_gmt"
                                        class="input @error('arrival_time_gmt') border-red-500 @enderror"
                                        value="{{ old('arrival_time_gmt') }}" required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Must be after departure time</p>
                                @error('arrival_time_gmt')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 pt-8">
                    <a href="{{ route('admin.schedules.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">
                        <i class="fas fa-save mr-2"></i>Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection