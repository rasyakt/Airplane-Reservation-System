@extends('layouts.admin')

@section('title', 'Edit Airport')

@section('content')
    <div class="max-w-2xl">
        <h2 class="text-xl font-semibold mb-6">Edit Airport: {{ $airport->iata_airport_code }}</h2>

        <form action="{{ route('admin.airports.update', $airport->iata_airport_code) }}" method="POST"
            class="bg-gray-800 p-6 rounded-lg">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">IATA Airport Code</label>
                <input type="text" value="{{ $airport->iata_airport_code }}"
                    class="w-full px-4 py-2 bg-gray-600 border border-gray-500 rounded-lg" disabled>
                <p class="text-xs text-gray-400 mt-1">Airport code cannot be changed</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Airport Name</label>
                <input type="text" name="name" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ old('name', $airport->name) }}" required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">City</label>
                <input type="text" name="city" maxlength="45"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ old('city', $airport->city) }}" required>
                @error('city')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Country</label>
                <select name="iata_country_code"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required>
                    @foreach ($countries as $country)
                        <option value="{{ $country->iata_country_code }}" {{ old('iata_country_code', $airport->iata_country_code) == $country->iata_country_code ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('iata_country_code')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update
                    Airport</button>
                <a href="{{ route('admin.airports.index') }}"
                    class="px-6 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection