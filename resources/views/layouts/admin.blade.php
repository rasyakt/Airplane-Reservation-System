<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-card min-h-screen fixed left-0 top-0 z-40">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plane text-white"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">Admin Panel</div>
                        <div class="text-xs text-gray-500">AirlineBooking</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4">
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 pb-2 px-4">
                        <div class="text-xs font-semibold text-gray-400 uppercase">Flight Management</div>
                    </div>

                    <a href="{{ route('admin.airports.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition {{ request()->routeIs('admin.airports.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                        <i class="fas fa-map-marker-alt w-5"></i>
                        <span>Airports</span>
                    </a>

                    <a href="{{ route('admin.aircraft.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition {{ request()->routeIs('admin.aircraft.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                        <i class="fas fa-plane w-5"></i>
                        <span>Aircraft</span>
                    </a>

                    <a href="{{ route('admin.schedules.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition {{ request()->routeIs('admin.schedules.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>Schedules</span>
                    </a>

                    <a href="{{ route('admin.flights.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition {{ request()->routeIs('admin.flights.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                        <i class="fas fa-plane-departure w-5"></i>
                        <span>Flights</span>
                    </a>

                    <div class="pt-4 pb-2 px-4">
                        <div class="text-xs font-semibold text-gray-400 uppercase">System</div>
                    </div>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition">
                        <i class="fas fa-users w-5"></i>
                        <span>Users</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-soft sticky top-0 z-30">
                <div class="px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('title')</h1>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- User Menu -->
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">Administrator</div>
                                </div>
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-red-600 transition">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span class="text-green-800 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            <span class="text-red-800 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>