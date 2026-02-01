@extends('layouts.admin')

@section('title', 'Add Flight')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.flights.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Add New Flight</h2>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.flights.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <!-- Flight Callsign -->
                    <div class="input-group">
                        <label class="label">Flight Callsign (e.g., GA201-SPECIAL)</label>
                        <input type="text" name="flight_call" class="input @error('flight_call') border-red-500 @enderror"
                            value="{{ old('flight_call') }}" placeholder="Enter Unique Flight Call" required>
                        @error('flight_call')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="input-group">
                        <label class="label">Status</label>
                        <select name="flight_status_id" class="input @error('flight_status_id') border-red-500 @enderror"
                            required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->flight_status_id }}" {{ old('flight_status_id') == $status->flight_status_id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('flight_status_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Schedule -->
                    <div class="input-group md:col-span-2">
                        <label class="label">Route & Schedule</label>
                        <select name="schedule_id" class="input @error('schedule_id') border-red-500 @enderror" required>
                            <option value="">Select Schedule</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->schedule_id }}" {{ old('schedule_id', request('schedule_id')) == $schedule->schedule_id ? 'selected' : '' }}>
                                    {{ $schedule->callsign }} | {{ $schedule->origin_iata_airport_code }} →
                                    {{ $schedule->dest_iata_airport_code }} | DEP:
                                    {{ $schedule->departure_time_gmt->format('d M H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('schedule_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 pt-8">
                    <a href="{{ route('admin.flights.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">Create Flight</button>
                </div>
            </form>
        </div>
    </div>
@endsection