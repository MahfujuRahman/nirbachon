@extends('layouts.agent')

@section('title', 'Upload Other Images')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('agent.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Upload Other Images
            </h2>
            <p class="text-green-50 mt-2">Upload additional images without linking to a specific result</p>
        </div>

        <form action="{{ route('agent.other-images.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Ashon Selection -->
                {{-- <div>
                    <label for="ashon_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Select Ashon <span class="text-red-500">*</span>
                    </label>
                    <select name="ashon_id" id="ashon_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Choose Ashon</option>
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

                <!-- Centar Selection -->
                <div>
                    <label for="centar_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Select Centar <span class="text-red-500">*</span>
                    </label>
                    <select name="centar_id" id="centar_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Choose Centar</option>
                        @foreach($centars as $centar)
                            <option value="{{ $centar->id }}" {{ old('centar_id') == $centar->id ? 'selected' : '' }}>
                                {{ $centar->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('centar_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Marka Selection -->
                <div>
                    <label for="marka_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Select Marka <span class="text-red-500">*</span>
                    </label>
                    <select name="marka_id" id="marka_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Choose Marka</option>
                        @foreach($markas as $marka)
                            <option value="{{ $marka->id }}" {{ old('marka_id') == $marka->id ? 'selected' : '' }}>
                                {{ $marka->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('marka_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Images Upload -->
            <div class="mb-6">
                <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload Images <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-green-500 transition">
                    <input type="file" name="images[]" id="images" multiple accept="image/*" required
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-green-50 file:text-green-700
                                  hover:file:bg-green-100
                                  cursor-pointer">
                    <p class="mt-2 text-xs text-gray-500">
                        <strong>📌 Tips:</strong> Hold <kbd class="px-2 py-1 bg-gray-100 rounded">Ctrl</kbd> to select multiple files at once, or
                        hold <kbd class="px-2 py-1 bg-gray-100 rounded">Shift</kbd> to select a range of files
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Accepted formats: JPG, PNG, GIF (Max 5MB per image)</p>
                </div>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('agent.dashboard') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg transition transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload Images
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        const files = Array.from(e.target.files);

        if (files.length > 0) {
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${event.target.result}"
                                 class="w-full h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm"
                                 alt="Preview">
                            <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg"></div>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });

            const countDiv = document.createElement('div');
            countDiv.className = 'col-span-full text-sm font-medium text-green-600 flex items-center';
            countDiv.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ${files.length} file(s) selected
            `;
            preview.insertBefore(countDiv, preview.firstChild);
        }
    });
</script>
@endsection
