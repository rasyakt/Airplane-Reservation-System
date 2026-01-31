@extends('layouts.admin')

@section('title', 'Aircraft Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Aircraft</h2>
        <a href="{{ route('admin.aircraft.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Aircraft
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Manufacturer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Model</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Instances</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($aircraft as $item)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm font-medium">{{ $item->aircraft_id }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->manufacturer->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->model }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->instances->count() }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('admin.aircraft.edit', $item->aircraft_id) }}"
                                class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form action="{{ route('admin.aircraft.destroy', $item->aircraft_id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"
                                    onclick="return confirm('Delete this aircraft?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No aircraft found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aircraft->links() }}
    </div>
@endsection