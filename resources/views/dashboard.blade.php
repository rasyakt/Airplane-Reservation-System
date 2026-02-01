<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-2">Welcome Back, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">You're logged in.</p>

                    @if(Auth::user()->role === 'admin')
                        <div
                            class="mt-4 p-4 bg-primary-50 rounded-lg border border-primary-200 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-primary-700">Admin Account Detected</span>
                                <p class="text-sm text-primary-600">You have access to the Administration Panel.</p>
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                Go to Admin Panel <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Book Flight -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4">
                            <i class="fas fa-plane-departure text-xl"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Book a Flight</h4>
                        <p class="text-gray-500 text-sm mb-4">Find and book your next journey.</p>
                        <a href="{{ route('home') }}" class="text-blue-600 font-semibold hover:underline">Search Flights
                            &rarr;</a>
                    </div>
                </div>

                <!-- My Profile -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4">
                            <i class="fas fa-user-circle text-xl"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-2">My Profile</h4>
                        <p class="text-gray-500 text-sm mb-4">Update your personal information.</p>
                        <a href="{{ route('profile.edit') }}" class="text-green-600 font-semibold hover:underline">Edit
                            Profile &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>