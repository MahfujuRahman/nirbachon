@extends('layouts.admin')

@section('header', 'Edit Marka')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Edit Marka</h3>
        </div>
        <form action="{{ route('admin.markas.update', $marka) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $marka->title) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($marka->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $marka->image) }}" alt="{{ $marka->title }}" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            @endif

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">New Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Image will be automatically resized to 200x200 pixels</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.markas.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Update Marka
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
