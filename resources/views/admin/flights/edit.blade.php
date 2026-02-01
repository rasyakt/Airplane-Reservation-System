@extends('layouts.admin')

@section('title', 'Edit Flight')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.flights.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Edit Flight: {{ $flight->flight_call }}</h2>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.flights.update', $flight->flight_call) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <!-- Flight Callsign (Read Only) -->
                    <div class="input-group">
                        <label class="label">Flight Callsign</label>
                        <input type="text" class="input bg-gray-50 text-gray-500 cursor-not-allowed"
                            value="{{ $flight->flight_call }}" readonly>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase italic">Primary key cannot be changed.</p>
                    </div>

                    <!-- Status -->
                    <div class="input-group">
                        <label class="label">Status</label>
                        <select name="flight_status_id" class="input" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->flight_status_id }}" {{ $flight->flight_status_id == $status->flight_status_id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Schedule -->
                    <div class="input-group md:col-span-2">
                        <label class="label">Route & Schedule</label>
                        <select name="schedule_id" class="input" required>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->schedule_id }}" {{ $flight->schedule_id == $schedule->schedule_id ? 'selected' : '' }}>
                                    {{ $schedule->callsign }} | {{ $schedule->origin_iata_airport_code }} →
                                    {{ $schedule->dest_iata_airport_code }} | DEP:
                                    {{ $schedule->departure_time_gmt->format('d M H:i') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 pt-8">
                    <a href="{{ route('admin.flights.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">Update Flight</button>
                </div>
            </form>
        </div>
    </div>
@endsection