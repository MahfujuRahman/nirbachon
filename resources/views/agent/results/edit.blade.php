@extends('layouts.agent')

@section('title', 'Edit Result')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Result</h2>
        <p class="text-gray-600">Update voting results</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg">
        <form action="{{ route('agent.results.update', $result) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="ashon_id" class="block text-sm font-medium text-gray-700 mb-2">Ashon</label>
                <select name="ashon_id" id="ashon_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ashon_id') border-red-500 @enderror">
                    <option value="">Select Ashon</option>
                    @foreach($ashons as $ashon)
                        <option value="{{ $ashon->id }}" {{ old('ashon_id', $result->ashon_id) == $ashon->id ? 'selected' : '' }}>
                            {{ $ashon->title }}
                        </option>
                    @endforeach
                </select>
                @error('ashon_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="centar_id" class="block text-sm font-medium text-gray-700 mb-2">Centar</label>
                <select name="centar_id" id="centar_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('centar_id') border-red-500 @enderror">
                    <option value="">Select Centar</option>
                    @foreach($centars as $centar)
                        <option value="{{ $centar->id }}" {{ old('centar_id', $result->centar_id) == $centar->id ? 'selected' : '' }}>
                            {{ $centar->title }}
                        </option>
                    @endforeach
                </select>
                @error('centar_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="total_vote" class="block text-sm font-medium text-gray-700 mb-2">Total Votes</label>
                <input type="number" name="total_vote" id="total_vote" value="{{ old('total_vote', $result->total_vote) }}" required min="0" step="0.01"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('total_vote') border-red-500 @enderror">
                @error('total_vote')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($result->images->count() > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach($result->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Result Image"
                                     class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                <form action="{{ route('agent.result-images.destroy', $image) }}" method="POST"
                                      class="absolute top-1 right-1" onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Add More Images (Optional)</label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('images.*') border-red-500 @enderror">
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">You can select multiple images. Max 5MB per image.</p>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('agent.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Update Result
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
