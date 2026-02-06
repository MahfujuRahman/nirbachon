@extends('layouts.admin')

@section('header', 'Agents')

@section('content')
<div class="bg-white shadow-lg rounded-lg">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
        <h3 class="text-lg font-semibold">Agents List</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm md:text-base w-full sm:w-auto text-center">
            Add New Agent
        </a>
    </div>
    <div class="p-4 md:p-6">
        <!-- Mobile View -->
        <div class="block lg:hidden space-y-4">
            @forelse($users as $user)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-2">
                        <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
                        <p class="text-xs text-gray-500 mt-1">Phone: {{ $user->phone ?? 'N/A' }}</p>
                        <p class="text-xs text-blue-600 mt-1">Centar: {{ $user->centar?->title ?? 'N/A' }}</p>
                    </div>
                    <div class="flex space-x-2 mt-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No agents found.</p>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->centar?->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No agents found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
