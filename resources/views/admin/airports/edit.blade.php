@extends('layouts.admin')

@section('title', 'Edit Airport')

@section('content')
    <div class="max-w-3xl">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit text-primary-500 mr-2"></i>Edit Airport: {{ $airport->name }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.airports.update', $airport->iata_airport_code) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-tag mr-2"></i>IATA Airport Code *
                        </label>
                        <input type="text" name="iata_airport_code" maxlength="3" class="input bg-gray-100"
                            value="{{ old('iata_airport_code', $airport->iata_airport_code) }}" readonly>
                        <p class="text-sm text-gray-500 mt-1">IATA code cannot be changed</p>
                    </div>

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-building mr-2"></i>Airport Name *
                        </label>
                        <input type="text" name="name" maxlength="255" class="input"
                            value="{{ old('name', $airport->name) }}" required>
                        @error('name')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-city mr-2"></i>City *
                        </label>
                        <input type="text" name="city" maxlength="45" class="input"
                            value="{{ old('city', $airport->city) }}" required>
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
                            @foreach ($countries as $country)
                                <option value="{{ $country->iata_country_code }}" {{ old('iata_country_code', $airport->iata_country_code) == $country->iata_country_code ? 'selected' : '' }}>
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
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>Update Airport
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