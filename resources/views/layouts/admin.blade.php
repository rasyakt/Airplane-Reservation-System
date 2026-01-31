<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-900 text-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 border-r border-gray-700">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-white">✈️ Admin Panel</h2>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.airports.index') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.airports.*') ? 'bg-gray-700 text-white' : '' }}">
                    Airports
                </a>
                <a href="{{ route('admin.aircraft.index') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.aircraft.*') ? 'bg-gray-700 text-white' : '' }}">
                    Aircraft
                </a>
                <a href="{{ route('admin.manufacturers.index') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.manufacturers.*') ? 'bg-gray-700 text-white' : '' }}">
                    Manufacturers
                </a>
                <a href="{{ route('admin.schedules.index') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.schedules.*') ? 'bg-gray-700 text-white' : '' }}">
                    Schedules
                </a>
                <a href="{{ route('admin.flights.index') }}"
                    class="block px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.flights.*') ? 'bg-gray-700 text-white' : '' }}">
                    Flights
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-gray-800 border-b border-gray-700 px-8 py-4">
                <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
            </header>

            <!-- Content -->
            <div class="p-8">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-900 border border-green-700 text-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-900 border border-red-700 text-red-200 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>