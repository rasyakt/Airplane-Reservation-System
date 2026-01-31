@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Welcome Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-gray-600 mt-1">Here's what's happening with your airline today.</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Revenue -->
        <div class="card p-6 border-l-4 border-primary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl text-primary-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>+12.5% from last month</span>
            </div>
        </div>

        <!-- Bookings -->
        <div class="card p-6 border-l-4 border-success-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Total Bookings</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalBookings) }}</h3>
                </div>
                <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-xl text-success-600"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>+8.2% from last week</span>
            </div>
        </div>

        <!-- Flights -->
        <div class="card p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Active Flights</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalFlights) }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plane-departure text-xl text-purple-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-500">
                <span>Operating on 4 current routes</span>
            </div>
        </div>

        <!-- Airports -->
        <div class="card p-6 border-l-4 border-secondary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Operated Airports</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalAirports) }}</h3>
                </div>
                <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-xl text-secondary-600"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-500">
                <span>Across 12 countries</span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <span><i class="fas fa-history mr-2 text-primary-500"></i>Recent Bookings</span>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs text-primary-600 hover:underline">View All</a>
            </div>
            <div class="table">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Passenger</th>
                            <th>Route</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="text-sm font-semibold text-gray-900">{{ $booking->client->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->client->email }}</div>
                                </td>
                                <td>
                                    <div class="text-xs font-medium text-gray-900">
                                        {{ $booking->flight->schedule->originAirport->iata_airport_code }} →
                                        {{ $booking->flight->schedule->destinationAirport->iata_airport_code }}
                                    </div>
                                </td>
                                <td>
                                    @if ($booking->payment_status == 'paid')
                                        <span class="badge-success text-[10px] py-0.5">Paid</span>
                                    @else
                                        <span class="badge-warning text-[10px] py-0.5">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-gray-500 text-sm">No recent bookings</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Routes -->
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-star mr-2 text-secondary-500"></i>Top Performing Routes</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse ($topRoutes as $route)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100">
                                    <i class="fas fa-route text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $route->origin_city }} to
                                        {{ $route->dest_city }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format($route->booking_count) }} bookings</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="w-24 bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full"
                                        style="width: {{ min(100, ($route->booking_count / max(1, $topRoutes->first()->booking_count)) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 text-sm">No route data available</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection