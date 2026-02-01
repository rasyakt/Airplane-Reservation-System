@extends('layouts.admin')

@section('title', 'Add System Admin')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center text-gray-500 hover:text-primary-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Add New Administrator</h2>
        </div>

        <div class="card p-8">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Name -->
                    <div class="input-group">
                        <label class="label">Full Name</label>
                        <input type="text" name="name" class="input @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" placeholder="Enter admin name" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" class="input @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" placeholder="admin@airline.com" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label class="label">Password</label>
                        <input type="password" name="password" class="input @error('password') border-red-500 @enderror"
                            placeholder="••••••••" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-group">
                        <label class="label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="input" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-8 mt-8 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary px-8">Create Admin Account</button>
                </div>
            </form>
        </div>
    </div>
@endsection