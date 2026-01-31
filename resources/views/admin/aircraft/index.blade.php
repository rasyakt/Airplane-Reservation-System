@extends('layouts.admin')

@section('title', 'Aircraft Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600 mt-1">Manage aircraft models and fleet</p>
        </div>
        <a href="{{ route('admin.aircraft.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>Add Aircraft
        </a>
    </div>

    <div class="card">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Instances</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aircraft as $item)
                        <tr>
                            <td><span class="badge-primary">#{{ $item->aircraft_id }}</span></td>
                            <td><strong>{{ $item->manufacturer->name ?? 'N/A' }}</strong></td>
                            <td>{{ $item->model }}</td>
                            <td><span class="badge-info">{{ $item->instances->count() }} units</span></td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.aircraft.edit', $item->aircraft_id) }}"
                                        class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium"><i
                                            class="fas fa-edit mr-1"></i>Edit</a>
                                    <form action="{{ route('admin.aircraft.destroy', $item->aircraft_id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium"
                                            onclick="return confirm('Delete this aircraft?')"><i
                                                class="fas fa-trash mr-1"></i>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12"><i class="fas fa-plane text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No aircraft found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $aircraft->links() }}
    </div>
@endsection