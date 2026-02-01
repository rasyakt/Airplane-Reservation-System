@extends('layouts.admin')

@section('title', 'Add Aircraft')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card">
            <h2 class="card-header">Add New Aircraft</h2>

            <form action="{{ route('admin.aircraft.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="label">Manufacturer</label>
                    <select name="aircraft_manufacturer_id" class="input" required>
                        <option value="">Select Manufacturer</option>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->aircraft_manufacturer_id }}" {{ old('aircraft_manufacturer_id') == $manufacturer->aircraft_manufacturer_id ? 'selected' : '' }}>
                                {{ $manufacturer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('aircraft_manufacturer_id')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="label">Model</label>
                    <input type="text" name="model" maxlength="45" class="input" value="{{ old('model') }}"
                        placeholder="e.g., 737-800" required>
                    @error('model')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary">Create Aircraft</button>
                    <a href="{{ route('admin.aircraft.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection