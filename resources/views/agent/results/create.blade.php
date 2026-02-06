@extends('layouts.agent')

@section('title', 'Upload Result')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Upload New Result</h2>
            <p class="text-gray-600">Submit voting results for {{ $agent->marka?->title ?? 'your marka' }}</p>
        </div>

        @if ($errors->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg">
            <form action="{{ route('agent.results.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="mb-4">
                    <label for="centar_id" class="block text-sm font-medium text-gray-700 mb-2">Centar</label>
                    <select name="centar_id" id="centar_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('centar_id') border-red-500 @enderror">
                        <option value="">Select Centar</option>
                        @foreach ($centars as $centar)
                            <option value="{{ $centar->id }}"
                                {{ old('centar_id', $agent->centar_id) == $centar->id ? 'selected' : '' }}>
                                {{ $centar->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('centar_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="marka_id" class="block text-sm font-medium text-gray-700 mb-2">Centar</label>
                    <select name="marka_id" id="marka_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('marka_id') border-red-500 @enderror">
                        <option value="">Select Marka</option>
                        @foreach ($markas as $marka)
                            <option value="{{ $marka->id }}"
                                {{ old('marka_id', $agent->marka_id) == $marka->id ? 'selected' : '' }}>
                                {{ $marka->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('marka_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="candidate_name" class="block text-sm font-medium text-gray-700 mb-2">Candidate Name
                        (Optional)</label>
                    <input type="text" name="candidate_name" id="candidate_name" value="{{ old('candidate_name') }}"
                        maxlength="255"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('candidate_name') border-red-500 @enderror">
                    @error('candidate_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="total_vote" class="block text-sm font-medium text-gray-700 mb-2">Total Votes</label>
                    <input type="number" name="total_vote" id="total_vote" value="{{ old('total_vote') }}" required
                        min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('total_vote') border-red-500 @enderror">
                    @error('total_vote')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Result Images (Optional - Multiple allowed)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <input type="file" name="images[]" id="images" accept="image/*" multiple
                            class="w-full cursor-pointer">
                    </div>
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-blue-600 font-medium">💡 Tip: Hold <kbd class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs">Ctrl</kbd> or <kbd class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs">Shift</kbd> to select multiple images at once!</p>
                    <p class="mt-1 text-xs text-gray-500">Max 5MB per image. Supported formats: JPEG, PNG, JPG, GIF</p>
                    <div id="imagePreview" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2"></div>
                </div>

                <div
                    class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('agent.dashboard') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                        Upload Result
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (this.files && this.files.length > 0) {
                // Show count of selected files
                const fileCount = this.files.length;
                const countDiv = document.createElement('div');
                countDiv.className = 'col-span-full mb-2 text-center text-sm font-semibold text-green-600';
                countDiv.textContent = `✓ ${fileCount} image${fileCount > 1 ? 's' : ''} selected`;
                preview.appendChild(countDiv);

                Array.from(this.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded border-2 border-gray-300">
                            <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                ${(file.size / 1024).toFixed(0)}KB
                            </div>
                        `;
                            preview.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection
