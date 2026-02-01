@extends('layouts.admin')

@section('title', 'Schedule Details')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.schedules.index') }}"
                    class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-900">Schedule Details: {{ $schedule->callsign }}</h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this schedule? This will also delete all associated flights.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 border-red-600">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="md:col-span-2 space-y-6">
                <!-- Route Info Card -->
                <div class="card p-8">
                    <div class="flex items-center justify-between mb-10">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-900">{{ $schedule->origin_iata_airport_code }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $schedule->originAirport->city }}</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center px-8">
                            <div class="text-xs text-primary-600 font-semibold mb-2 uppercase tracking-widest">
                                Direct Flight
                            </div>
                            <div class="w-full flex items-center gap-2">
                                <div class="h-0.5 bg-primary-100 flex-1"></div>
                                <i class="fas fa-plane text-primary-500 text-sm"></i>
                                <div class="h-0.5 bg-primary-100 flex-1"></div>
                            </div>
                            <div class="text-xs text-gray-400 mt-2">
                                GMT Departure & Arrival
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-900">{{ $schedule->dest_iata_airport_code }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $schedule->destinationAirport->city }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase mb-2">Departure</div>
                            <div class="text-lg font-bold text-gray-900">
                                {{ $schedule->departure_time_gmt->format('D, d M Y') }}</div>
                            <div class="text-2xl font-black text-primary-600">
                                {{ $schedule->departure_time_gmt->format('H:i') }} <span
                                    class="text-sm font-normal text-gray-400 uppercase">GMT</span></div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-semibold text-gray-400 uppercase mb-2">Arrival</div>
                            <div class="text-lg font-bold text-gray-900">
                                {{ $schedule->arrival_time_gmt->format('D, d M Y') }}</div>
                            <div class="text-2xl font-black text-secondary-600">
                                {{ $schedule->arrival_time_gmt->format('H:i') }} <span
                                    class="text-sm font-normal text-gray-400 uppercase">GMT</span></div>
                        </div>
                    </div>
                </div>

                <!-- Associated Flights -->
                <div class="card">
                    <div class="card-header flex justify-between items-center">
                        <span>Flights using this schedule</span>
                        <a href="{{ route('admin.flights.create', ['schedule_id' => $schedule->schedule_id]) }}"
                            class="text-xs text-primary-600 hover:underline">Add Flight</a>
                    </div>
                    <div class="p-6">
                        @forelse($schedule->flights as $flight)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl mb-3 last:mb-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="fas fa-plane-departure text-primary-500"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">Flight {{ $flight->flight_call }}</div>
                                        <div class="text-xs text-gray-500">{{ $flight->status->name }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.flights.show', $flight->flight_call) }}"
                                    class="p-2 text-gray-400 hover:text-primary-600 transition">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-500 text-sm italic">No flights registered for this schedule.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Sidebar Stats -->
                <div class="card p-6 bg-primary-600 text-white border-none shadow-glow">
                    <div class="text-xs font-semibold text-blue-100 uppercase mb-4 tracking-wider">Quick Summary</div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Callsign</span>
                            <span class="font-bold">{{ $schedule->callsign }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Active Flights</span>
                            <span class="font-bold">{{ $schedule->flights->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Duration</span>
                            <span class="font-bold">
                                @php
                                    $diff = $schedule->departure_time_gmt->diff($schedule->arrival_time_gmt);
                                    echo $diff->h . 'h ' . $diff->i . 'm';
                                @endphp
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="text-xs font-semibold text-gray-400 uppercase mb-4 tracking-wider">Audit Info</div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start text-xs">
                            <span class="text-gray-500">ID</span>
                            <span class="text-gray-800 font-mono">#{{ $schedule->schedule_id }}</span>
                        </div>
                        <div class="flex justify-between items-start text-xs">
                            <span class="text-gray-500">Created At</span>
                            <span class="text-gray-800">{{ $schedule->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-start text-xs">
                            <span class="text-gray-500">Last Update</span>
                            <span class="text-gray-800">{{ $schedule->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection