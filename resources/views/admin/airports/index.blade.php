@extends('layouts.admin')

@section('title', 'Airports Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Airports</h2>
        <a href="{{ route('admin.airports.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Airport
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">City</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Country</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($airports as $airport)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm font-medium">{{ $airport->iata_airport_code }}</td>
                        <td class="px-6 py-4 text-sm">{{ $airport->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $airport->city }}</td>
                        <td class="px-6 py-4 text-sm">{{ $airport->country->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('admin.airports.edit', $airport->iata_airport_code) }}"
                                class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form action="{{ route('admin.airports.destroy', $airport->iata_airport_code) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No airports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $airports->links() }}
    </div>
@endsection