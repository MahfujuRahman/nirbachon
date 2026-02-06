@extends('layouts.admin')

@section('header', 'Result Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.results.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Results
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 text-white">
            <h2 class="text-2xl font-bold">Result #{{ $result->id }}</h2>
            <p class="text-blue-100 text-sm mt-1">Uploaded: {{ $result->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Ashon</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $result->ashon->title }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Centar (Polling Station)</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $result->centar->title }}</p>
                        @if($result->centar->address)
                            <p class="text-sm text-gray-600 mt-1">{{ $result->centar->address }}</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Uploaded By (Agent)</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $result->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $result->user->email }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Marka (Political Party)</h3>
                        <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-lg">
                            @if($result->marka->image)
                                <img src="{{ asset('storage/' . $result->marka->image) }}"
                                     alt="{{ $result->marka->title }}"
                                     class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200">
                            @endif
                            <div>
                                <p class="text-lg font-bold text-gray-900">{{ $result->marka->title }}</p>
                            </div>
                        </div>
                    </div>

                    @if($result->candidate_name)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Candidate Name</h3>
                            <p class="text-lg font-semibold text-gray-900">{{ $result->candidate_name }}</p>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Total Votes</h3>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($result->total_vote) }}</p>
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            @if($result->images->count() > 0)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Result Images ({{ $result->images->count() }})
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($result->images as $image)
                            <div class="relative group">
                                <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $image->image) }}"
                                         alt="Result Image"
                                         class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 hover:border-blue-500 transition cursor-pointer">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-t border-gray-200 pt-6">
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No images uploaded for this result</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="border-t border-gray-200 pt-6 mt-6 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                <div class="text-sm text-gray-500">
                    Last updated: {{ $result->updated_at->format('F d, Y \a\t H:i') }}
                </div>
                <form action="{{ route('admin.results.destroy', $result) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this result and all its images?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                        Delete Result
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
