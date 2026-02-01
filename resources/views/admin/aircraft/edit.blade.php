@extends('layouts.admin')

@section('title', 'Edit Aircraft')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card">
            <h2 class="card-header">Edit Aircraft: {{ $aircraft->model }}</h2>

            <form action="{{ route('admin.aircraft.update', $aircraft->aircraft_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="label">Manufacturer</label>
                    <select name="aircraft_manufacturer_id"
                        class="input"
                        required>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->aircraft_manufacturer_id }}" {{ old('aircraft_manufacturer_id', $aircraft->aircraft_manufacturer_id) == $manufacturer->aircraft_manufacturer_id ? 'selected' : '' }}>
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
                    <input type="text" name="model" maxlength="45"
                        class="input"
                        value="{{ old('model', $aircraft->model) }}" required>
                    @error('model')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary">Update Aircraft</button>
                    <a href="{{ route('admin.aircraft.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection