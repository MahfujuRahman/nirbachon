@extends('layouts.app')

@section('title', 'Live Results - Nirbachon')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Live Voting Results</h1>
            <p class="text-xl text-gray-600">Real-time election results</p>
        </div>

        <!-- Ashon Filter -->
        @if($ashons->count() > 1)
            <div class="mb-8 bg-white rounded-lg shadow-lg p-4">
                <form method="GET" action="{{ route('home') }}" class="flex flex-wrap items-center gap-4">
                    <label for="ashon_id" class="text-sm font-medium text-gray-700">Filter by Ashon:</label>
                    <select name="ashon_id" id="ashon_id" onchange="this.form.submit()"
                            class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Ashons</option>
                        @foreach($ashons as $ashon)
                            <option value="{{ $ashon->id }}" {{ $selectedAshon == $ashon->id ? 'selected' : '' }}>
                                {{ $ashon->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif

        <!-- Total Votes -->
        <div class="mb-8 text-center">
            <div class="inline-block bg-white rounded-lg shadow-lg px-8 py-4">
                <p class="text-sm text-gray-600 mb-1">Total Votes Cast</p>
                <p class="text-4xl font-bold text-blue-600">{{ number_format($totalVotes) }}</p>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-6">
            @forelse($results as $index => $result)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                            <!-- Rank Badge -->
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold
                                    {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                    {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                    {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                    {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }}">
                                    #{{ $index + 1 }}
                                </div>
                            </div>

                            <!-- Marka Info -->
                            <div class="flex-shrink-0">
                                @if($result->marka->image)
                                    <img src="{{ asset('storage/' . $result->marka->image) }}"
                                         alt="{{ $result->marka->title }}"
                                         class="w-24 h-24 object-cover rounded-lg border-4 border-gray-200">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Marka Details -->
                            <div class="flex-1">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    {{ $result->marka->title }}
                                </h3>
                                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-3">
                                    <div>
                                        <span class="text-3xl font-bold text-blue-600">
                                            {{ number_format($result->total_votes) }}
                                        </span>
                                        <span class="text-gray-600 ml-2">votes</span>
                                    </div>
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $result->percentage }}%
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500 ease-out"
                                         style="width: {{ $result->percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Results Available</h3>
                    <p class="text-gray-600">Results will appear here once voting data is uploaded.</p>
                </div>
            @endforelse
        </div>

        <!-- Auto Refresh Notice -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                <svg class="inline-block w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Page auto-refreshes every 30 seconds
            </p>
        </div>
    </div>
</div>

<script>
    // Auto-refresh every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection
