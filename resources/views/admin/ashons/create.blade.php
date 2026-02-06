@extends('layouts.admin')

@section('header', 'Create Ashon')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Create New Ashon</h3>
        </div>
        <form action="{{ route('admin.ashons.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.ashons.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Create Ashon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
