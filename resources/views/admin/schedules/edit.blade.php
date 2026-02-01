@extends('layouts.admin')

@section('title', 'Edit Schedule')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.schedules.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Edit Schedule</h2>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.schedules.update', $schedule->schedule_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div class="input-group">
                        <label class="label">Origin Airport</label>
                        <select name="origin_iata_airport_code" class="input" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_airport_code }}" {{ $schedule->origin_iata_airport_code == $airport->iata_airport_code ? 'selected' : '' }}>
                                    {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label">Destination Airport</label>
                        <select name="dest_iata_airport_code" class="input" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_airport_code }}" {{ $schedule->dest_iata_airport_code == $airport->iata_airport_code ? 'selected' : '' }}>
                                    {{ $airport->iata_airport_code }} - {{ $airport->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label">Departure Time (GMT)</label>
                        <input type="datetime-local" name="departure_time_gmt" class="input"
                            value="{{ $schedule->departure_time_gmt->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="input-group">
                        <label class="label">Arrival Time (GMT)</label>
                        <input type="datetime-local" name="arrival_time_gmt" class="input"
                            value="{{ $schedule->arrival_time_gmt->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="input-group md:col-span-2">
                        <label class="label">Callsign</label>
                        <input type="text" name="callsign" class="input" value="{{ $schedule->callsign }}" required>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.schedules.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>
@endsection