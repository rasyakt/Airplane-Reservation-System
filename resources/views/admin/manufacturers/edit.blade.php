@extends('layouts.admin')

@section('title', 'Edit Manufacturer')

@section('content')
    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit text-primary-500 mr-2"></i>Edit Manufacturer: {{ $manufacturer->name }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manufacturers.update', $manufacturer->manufacturer_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-group">
                        <label class="label">
                            <i class="fas fa-building mr-2"></i>Manufacturer Name *
                        </label>
                        <input type="text" name="name" maxlength="255" class="input"
                            value="{{ old('name', $manufacturer->name) }}" required>
                        @error('name')
                            <p class="text-danger-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>Update Manufacturer
                        </button>
                        <a href="{{ route('admin.manufacturers.index') }}" class="btn-secondary">
                            <i class="fas fa-times-circle"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection