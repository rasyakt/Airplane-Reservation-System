@extends('layouts.admin')

@section('title', 'Aircraft Manufacturers')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Manage aircraft manufacturers and their details</p>
        </div>
        <a href="{{ route('admin.manufacturers.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>Add Manufacturer
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Total Manufacturers</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $manufacturers->total() }}</div>
                </div>
                <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-industry text-2xl text-primary-600"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Aircraft Models</div>
                    <div class="text-3xl font-bold text-gray-900">{{ \App\Models\Aircraft::count() }}</div>
                </div>
                <div class="w-14 h-14 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plane text-2xl text-secondary-600"></i>
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
                        <th>ID</th>
                        <th>Manufacturer Name</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($manufacturers as $manufacturer)
                        <tr>
                            <td>
                                <span class="badge-primary">#{{ $manufacturer->manufacturer_id }}</span>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-900">{{ $manufacturer->name }}</div>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.manufacturers.edit', $manufacturer->manufacturer_id) }}"
                                        class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.manufacturers.destroy', $manufacturer->manufacturer_id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium"
                                            onclick="return confirm('Delete this manufacturer?')">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-12">
                                <i class="fas fa-industry text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No manufacturers found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $manufacturers->links() }}
    </div>
@endsection