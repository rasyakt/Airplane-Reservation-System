@extends('layouts.admin')

@section('title', 'Create Schedule')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.schedules.index') }}"
            class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Add New Flight Schedule</h2>
    </div>

    <div class="card p-8">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Origin -->
                <div class="input-group">
                    <label class="label">Origin Airport</label>
                    <select name="origin_iata_airport_code"
                        class="input @error('origin_iata_airport_code') border-red-500 @enderror" required>
                        <option value="">Select Origin</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport->iata_airport_code }}" {{ old('origin_iata_airport_code') == $airport->iata_airport_code ? 'selected' : '' }}>
                                {{ $airport->iata_airport_code }} - {{ $airport->city }}
                            </option>
                        @endforeach
                    </select>
                    @error('origin_iata_airport_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination -->
                <div class="input-group">
                    <label class="label">Destination Airport</label>
                    <select name="dest_iata_airport_code"
                        class="input @error('dest_iata_airport_code') border-red-500 @enderror" required>
                        <option value="">Select Destination</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport->iata_airport_code }}" {{ old('dest_iata_airport_code') == $airport->iata_airport_code ? 'selected' : '' }}>
                                {{ $airport->iata_airport_code }} - {{ $airport->city }}
                            </option>
                        @endforeach
                    </select>
                    @error('dest_iata_airport_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Departure Time -->
                <div class="input-group">
                    <label class="label">Departure Time (GMT)</label>
                    <input type="datetime-local" name="departure_time_gmt"
                        class="input @error('departure_time_gmt') border-red-500 @enderror"
                        value="{{ old('departure_time_gmt') }}" required>
                    @error('departure_time_gmt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arrival Time -->
                <div class="input-group">
                    <label class="label">Arrival Time (GMT)</label>
                    <input type="datetime-local" name="arrival_time_gmt"
                        class="input @error('arrival_time_gmt') border-red-500 @enderror"
                        value="{{ old('arrival_time_gmt') }}" required>
                    @error('arrival_time_gmt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Callsign (Missing in previous step, adding now) -->
                <div class="input-group md:col-span-2">
                    <label class="label">Schedule Callsign (e.g., GA202)</label>
                    <input type="text" name="callsign" class="input @error('callsign') border-red-500 @enderror"
                        value="{{ old('callsign') }}" placeholder="Enter Callsign" required>
                    @error('callsign')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-gray-100 pt-8">
                <a href="{{ route('admin.schedules.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary px-8">Create Schedule</button>
            </div>
        </form>
    </div>
</div>
@extends('layouts.admin')
@section('title', 'Create Schedule')
@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.schedules.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Add New Flight Schedule</h2>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div class="input-group">
                        <label class="label">Origin Airport</label>
                        <select name="origin_iata_airport_code" class="input" required>
                            <option value="">Select Origin</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_airport_code }}">{{ $airport->iata_airport_code }} -
                                    {{ $airport->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label">Destination Airport</label>
                        <select name="dest_iata_airport_code" class="input" required>
                            <option value="">Select Destination</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_airport_code }}">{{ $airport->iata_airport_code }} -
                                    {{ $airport->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label">Departure Time (GMT)</label>
                        <input type="datetime-local" name="departure_time_gmt" class="input" required>
                    </div>
                    <div class="input-group">
                        <label class="label">Arrival Time (GMT)</label>
                        <input type="datetime-local" name="arrival_time_gmt" class="input" required>
                    </div>
                    <!-- Adding callsign field as discovered missing in previous step -->
                    <div class="input-group md:col-span-2">
                        <label class="label">Callsign (e.g., GA201)</label>
                        <input type="text" name="callsign" class="input" required placeholder="Enter flight callsign">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.schedules.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
@endsection