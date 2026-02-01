@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">System Administrators</h2>
            <p class="text-sm text-gray-500 mt-1">Manage users with access to this admin panel.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <i class="fas fa-user-plus mr-2"></i>Add Admin
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-bold text-xs">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                    @if($user->id === auth()->id())
                                        <span class="badge-info text-[8px] py-0.5 px-1.5">You</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-sm text-gray-600 tracking-tight">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="p-2 text-gray-400 hover:text-secondary-600 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Remove this admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection