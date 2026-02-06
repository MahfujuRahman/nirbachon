@extends('layouts.admin')

@section('header', 'Results Management')

@section('content')
<!-- Centar Submission Status Dashboard -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Centars</p>
                <p class="text-3xl font-bold text-gray-900">{{ $centarStats->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Submitted</p>
                <p class="text-3xl font-bold text-green-600">{{ $submittedCount }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Not Submitted</p>
                <p class="text-3xl font-bold text-red-600">{{ $notSubmittedCount }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Centar Submission Details -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Centar Submission Status</h3>
        <button onclick="toggleCentarList()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
            <span id="toggleText">Show All</span>
        </button>
    </div>
    <div id="centarList" class="hidden p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($centarStats->sortBy('title') as $stat)
                <div class="flex items-center justify-between p-3 rounded-lg border {{ $stat['has_results'] ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate">{{ $stat['title'] }}</p>
                        @if($stat['address'])
                            <p class="text-xs text-gray-600 truncate">{{ $stat['address'] }}</p>
                        @endif
                        @if($stat['has_results'])
                            <p class="text-xs text-green-600 mt-1">{{ $stat['result_count'] }} result(s)</p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 ml-3">
                        @if($stat['has_results'])
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white shadow-lg rounded-lg">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Filter Results</h3>

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.results.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- <div>
                <label for="ashon_id" class="block text-sm font-medium text-gray-700 mb-1">Ashon</label>
                <select name="ashon_id" id="ashon_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Ashons</option>
                    @foreach($ashons as $ashon)
                        <option value="{{ $ashon->id }}" {{ request('ashon_id') == $ashon->id ? 'selected' : '' }}>
                            {{ $ashon->title }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

            <div>
                <label for="centar_id" class="block text-sm font-medium text-gray-700 mb-1">Centar</label>
                <select name="centar_id" id="centar_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Centars</option>
                    @foreach($centars as $centar)
                        <option value="{{ $centar->id }}" {{ request('centar_id') == $centar->id ? 'selected' : '' }}>
                            {{ $centar->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="marka_id" class="block text-sm font-medium text-gray-700 mb-1">Marka</label>
                <select name="marka_id" id="marka_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Markas</option>
                    @foreach($markas as $marka)
                        <option value="{{ $marka->id }}" {{ request('marka_id') == $marka->id ? 'selected' : '' }}>
                            {{ $marka->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="submitted_centars" class="block text-sm font-medium text-gray-700 mb-1">Submission Status</label>
                <select name="submitted_centars" id="submitted_centars" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ request('submitted_centars', 'all') == 'all' ? 'selected' : '' }}>All Centars</option>
                    <option value="submit" {{ request('submitted_centars') == 'submit' ? 'selected' : '' }}>Submitted Centars</option>
                    <option value="nonsubmit" {{ request('submitted_centars') == 'nonsubmit' ? 'selected' : '' }}>Not Submitted Centars</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.results.index') }}" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition text-center">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <div class="p-4 md:p-6">
        @if($showCentarList)
            <!-- Filtered Centars List -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    @if(request('submitted_centars') === 'submit')
                        Centars with Results ({{ $filteredCentars->count() }})
                    @else
                        Centars without Results ({{ $filteredCentars->count() }})
                    @endif
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($filteredCentars as $centar)
                    <div class="bg-white border-2 rounded-lg shadow-sm hover:shadow-md transition {{ in_array($centar->id, $centarsWithResults) ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }}">
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-base mb-1">{{ $centar->title }}</h4>
                                    @if($centar->address)
                                        <p class="text-xs text-gray-600 mb-2">{{ $centar->address }}</p>
                                    @endif
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                    @if(in_array($centar->id, $centarsWithResults))
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            @php
                                $centarResultCount = $centarResultData[$centar->id]['count'] ?? 0;
                                $centarTotalVotes = $centarResultData[$centar->id]['votes'] ?? 0;
                            @endphp

                            @if($centarResultCount > 0)
                                <div class="border-t border-green-200 pt-2 mt-2">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Results:</span>
                                        <span class="font-semibold text-green-700">{{ $centarResultCount }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Total Votes:</span>
                                        <span class="font-semibold text-green-700">{{ number_format($centarTotalVotes) }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="border-t border-red-200 pt-2 mt-2">
                                    <p class="text-xs text-red-600 font-medium">No results submitted</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        No centars found.
                    </div>
                @endforelse
            </div>
        @else
            <!-- Regular Results List -->
        <!-- Mobile View -->
        <div class="block lg:hidden space-y-4">
            @forelse($results as $result)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-blue-600">{{ $result->ashon->title }}</span>
                            <span class="text-xs text-gray-500">ID: {{ $result->id }}</span>
                        </div>
                        <p class="font-semibold text-gray-900 mb-1">{{ $result->centar->title }}</p>
                        <div class="flex items-center space-x-2 text-sm">
                            @if($result->marka->image)
                                <img src="{{ asset('storage/' . $result->marka->image) }}" alt="{{ $result->marka->title }}" class="w-8 h-8 object-cover rounded">
                            @endif
                            <span class="text-green-600 font-semibold">{{ $result->marka->title }}</span>
                        </div>
                        <p class="text-lg font-bold text-gray-900 mt-2">{{ number_format($result->total_vote) }} votes</p>
                        @if($result->candidate_name)
                            <p class="text-xs text-gray-600 mt-1">Candidate: {{ $result->candidate_name }}</p>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Agent: {{ $result->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $result->created_at->format('M d, Y H:i') }}</p>
                        @if($result->images->count() > 0)
                            <p class="text-xs text-purple-600 mt-1">📷 {{ $result->images->count() }} images</p>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.results.show', $result) }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                            View Details
                        </a>
                        <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this result?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No results found.</p>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ashon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Votes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Images</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($results as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->ashon->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $result->centar->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    @if($result->marka->image)
                                        <img src="{{ asset('storage/' . $result->marka->image) }}" alt="{{ $result->marka->title }}" class="w-8 h-8 object-cover rounded">
                                    @endif
                                    <span class="text-gray-900">{{ $result->marka->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($result->total_vote) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($result->images->count() > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                        📷 {{ $result->images->count() }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.results.show', $result) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this result?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $results->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function toggleCentarList() {
        const centarList = document.getElementById('centarList');
        const toggleText = document.getElementById('toggleText');

        if (centarList.classList.contains('hidden')) {
            centarList.classList.remove('hidden');
            toggleText.textContent = 'Hide';
        } else {
            centarList.classList.add('hidden');
            toggleText.textContent = 'Show All';
        }
    }
</script>
@endsection
