@extends('layouts.admin')

@section('header', 'Create Centar')

@section('content')
<div class="max-w-8xl">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Create New Centar</h3>
        </div>
        <form action="{{ route('admin.centars.store') }}" method="POST" class="p-6">
            @csrf
            {{-- <div class="mb-4">
                <label for="ashon_id" class="block text-sm font-medium text-gray-700 mb-2">Ashon</label>
                <select name="ashon_id" id="ashon_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ashon_id') border-red-500 @enderror">
                    <option value="">Select Ashon</option>
                    @foreach($ashons as $ashon)
                        <option value="{{ $ashon->id }}" {{ old('ashon_id') == $ashon->id ? 'selected' : '' }}>
                            {{ $ashon->title }}
                        </option>
                    @endforeach
                </select>
                @error('ashon_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea name="address" id="address" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.centars.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Create Centar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
