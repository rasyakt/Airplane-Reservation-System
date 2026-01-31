@extends('layouts.admin')

@section('title', 'Add Aircraft')

@section('content')
    <div class="max-w-2xl">
        <h2 class="text-xl font-semibold mb-6">Add New Aircraft</h2>

        <form action="{{ route('admin.aircraft.store') }}" method="POST" class="bg-gray-800 p-6 rounded-lg">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Manufacturer</label>
                <select name="aircraft_manufacturer_id"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">Select Manufacturer</option>
                    @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->aircraft_manufacturer_id }}" {{ old('aircraft_manufacturer_id') == $manufacturer->aircraft_manufacturer_id ? 'selected' : '' }}>
                            {{ $manufacturer->name }}
                        </option>
                    @endforeach
                </select>
                @error('aircraft_manufacturer_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Model</label>
                <input type="text" name="model" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ old('model') }}" placeholder="e.g., 737-800" required>
                @error('model')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create
                    Aircraft</button>
                <a href="{{ route('admin.aircraft.index') }}"
                    class="px-6 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection