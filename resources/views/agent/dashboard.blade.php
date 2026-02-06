@extends('layouts.agent')

@section('title', 'Agent Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">My Results</h2>
    <p class="text-gray-600">Manage your uploaded voting results</p>
</div>

<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    @forelse($results as $result)
        <div class="border-b border-gray-200 last:border-b-0 p-6 hover:bg-gray-50 transition">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $result->marka->title }}</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Ashon:</span> {{ $result->ashon?->title ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Centar:</span> {{ $result->centar->title }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total Votes:</span>
                            <span class="text-lg font-bold text-blue-600">{{ number_format($result->total_vote) }}</span>
                        </p>
                        <p class="text-xs text-gray-500">
                            Uploaded: {{ $result->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('agent.results.edit', $result) }}"
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                        Edit
                    </a>
                </div>
            </div>

            @if($result->images->count() > 0)
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Uploaded Images:</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach($result->images as $image)
                            <img src="{{ asset('storage/' . $image->image) }}" alt="Result Image"
                                 class="w-full h-32 object-cover rounded-lg border border-gray-300">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="p-8 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No results uploaded</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by uploading a new result.</p>
            <div class="mt-6">
                <a href="{{ route('agent.results.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Upload New Result
                </a>
            </div>
        </div>
    @endforelse
</div>

@if($results->hasPages())
    <div class="mt-6">
        {{ $results->links() }}
    </div>
@endif
@endsection
