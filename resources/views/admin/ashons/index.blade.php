@extends('layouts.admin')

@section('header', 'Ashons')

@section('content')
<div class="bg-white shadow-lg rounded-lg">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
        <h3 class="text-lg font-semibold">Ashons List</h3>
        <a href="{{ route('admin.ashons.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm md:text-base w-full sm:w-auto text-center">
            Add New Ashon
        </a>
    </div>
    <div class="p-4 md:p-6">
        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            @forelse($ashons as $ashon)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs text-gray-500">ID: {{ $ashon->id }}</p>
                            <p class="font-semibold text-gray-900">{{ $ashon->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $ashon->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-3">
                        <a href="{{ route('admin.ashons.edit', $ashon) }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.ashons.destroy', $ashon) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No ashons found.</p>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ashons as $ashon)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ashon->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ashon->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ashon->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.ashons.edit', $ashon) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="{{ route('admin.ashons.destroy', $ashon) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No ashons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $ashons->links() }}
        </div>
    </div>
</div>
@endsection
