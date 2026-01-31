@extends('layouts.admin')

@section('title', 'Add New Airport')

@section('content')
    <div class="max-w-3xl">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>Airport Information
            </div>
            <div class="card-body">
                <form action="{{ route('admin.airports.store') }}" method="POST">
                    @csrf

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-tag mr-2"></i>IATA Airport Code *
                        </label>
                        <input type="text" name="iata_airport_code" maxlength="3" class="input"
                            value="{{ old('iata_airport_code') }}" placeholder="e.g., CGK" required>
                        <p class="text-sm text-gray-500 mt-1">3-letter IATA code (e.g., CGK, SIN, BKK)</p>
                        @error('iata_airport_code')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-building mr-2"></i>Airport Name *
                        </label>
                        <input type="text" name="name" maxlength="255" class="input" value="{{ old('name') }}"
                            placeholder="e.g., Soekarno-Hatta International Airport" required>
                        @error('name')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-city mr-2"></i>City *
                        </label>
                        <input type="text" name="city" maxlength="45" class="input" value="{{ old('city') }}"
                            placeholder="e.g., Jakarta" required>
                        @error('city')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="input-group mb-6">
                        <label class="label">
                            <i class="fas fa-flag mr-2"></i>Country *
                        </label>
                        <select name="iata_country_code" class="input" required>
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->iata_country_code }}" {{ old('iata_country_code') == $country->iata_country_code ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('iata_country_code')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-success">
                            <i class="fas fa-check-circle"></i>Create Airport
                        </button>
                        <a href="{{ route('admin.airports.index') }}" class="btn-secondary">
                            <i class="fas fa-times-circle"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection