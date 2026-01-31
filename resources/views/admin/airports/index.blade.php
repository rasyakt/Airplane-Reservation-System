@extends('layouts.admin')

@section('title', 'Airports Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Manage all airport locations and IATA codes</p>
        </div>
        <a href="{{ route('admin.airports.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>Add Airport
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Total Airports</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $airports->total() }}</div>
                </div>
                <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-2xl text-primary-600"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Countries</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $airports->pluck('country_id')->unique()->count() }}
                    </div>
                </div>
                <div class="w-14 h-14 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-globe text-2xl text-secondary-600"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Active Routes</div>
                    <div class="text-3xl font-bold text-gray-900">0</div>
                </div>
                <div class="w-14 h-14 bg-success-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-route text-2xl text-success-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>IATA Code</th>
                        <th>Airport Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($airports as $airport)
                        <tr>
                            <td>
                                <span class="badge-primary">{{ $airport->iata_airport_code }}</span>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-900">{{ $airport->name }}</div>
                            </td>
                            <td>{{ $airport->city }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-flag text-gray-400"></i>
                                    {{ $airport->country->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.airports.edit', $airport->iata_airport_code) }}"
                                        class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.airports.destroy', $airport->iata_airport_code) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium"
                                            onclick="return confirm('Delete this airport?')">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No airports found. Add your first airport to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $airports->links() }}
    </div>
@endsection