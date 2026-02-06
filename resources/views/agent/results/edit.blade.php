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
                <label class="block text-sm font-medium text-gray-700 mb-2">Marka</label>
                <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    {{ auth()->user()->marka?->title ?? 'No Marka Assigned' }}
                </div>
            </div>

            <div class="mb-4">
                <label for="candidate_name" class="block text-sm font-medium text-gray-700 mb-2">Candidate Name (Optional)</label>
                <input type="text" name="candidate_name" id="candidate_name" value="{{ old('candidate_name', $result->candidate_name) }}" maxlength="255"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('candidate_name') border-red-500 @enderror">
                @error('candidate_name')
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images ({{ $result->images->count() }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($result->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Result Image"
                                     class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                <button type="button"
                                        onclick="deleteImage('{{ route('agent.result-images.destroy', $image) }}')"
                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                    Add More Images (Optional - Multiple allowed)
                </label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('images.*') border-red-500 @enderror">
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">You can select multiple images. Max 5MB per image. Supported formats: JPEG, PNG, JPG, GIF</p>
                <div id="imagePreview" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2"></div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('agent.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Update Result
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imagesInput = document.getElementById('images');
    const preview = document.getElementById('imagePreview');

    if (imagesInput) {
        imagesInput.addEventListener('change', function(e) {
            preview.innerHTML = '';

            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach((file) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded border-2 border-green-300">
                                <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                    NEW - ${(file.size / 1024).toFixed(0)}KB
                                </div>
                            `;
                            preview.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    }
});

// Delete image function
function deleteImage(url) {
    if (confirm('Delete this image?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

</script>
@endsection
