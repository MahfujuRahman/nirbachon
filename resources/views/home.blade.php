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

        <!-- Filters -->
        <div class="mb-8 bg-white rounded-lg shadow-lg p-4">
            <form method="GET" action="{{ route('home') }}" id="filterForm" class="flex flex-wrap items-center gap-4">
                @if($ashons->count() > 1)
                    <div class="flex-1 min-w-[200px]">
                        <label for="ashon_id" class="text-sm font-medium text-gray-700 mb-1 block">Filter by Ashon:</label>
                        <select name="ashon_id" id="ashon_id" onchange="document.getElementById('filterForm').submit()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Ashons</option>
                            @foreach($ashons as $ashon)
                                <option value="{{ $ashon->id }}" {{ $selectedAshon == $ashon->id ? 'selected' : '' }}>
                                    {{ $ashon->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex-1 min-w-[200px]">
                    <label for="centar_search" class="text-sm font-medium text-gray-700 mb-1 block">Search & Filter by Centar:</label>
                    <div class="relative">
                        <input type="text" id="centar_search" placeholder="Type to search centars..."
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               onclick="toggleCentarDropdown()" onkeyup="filterCentars()">
                        <svg class="absolute right-3 top-3 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>

                        <!-- Hidden select for form submission -->
                        <select name="centar_id" id="centar_id" class="hidden">
                            <option value="">All Centars</option>
                            @foreach($centars as $centar)
                                <option value="{{ $centar->id }}" {{ $selectedCentar == $centar->id ? 'selected' : '' }}>
                                    {{ $centar->title }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Custom Dropdown -->
                        <div id="centarDropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <div class="p-2 hover:bg-blue-50 cursor-pointer border-b border-gray-200" onclick="selectCentar('', 'All Centars')">
                                <span class="font-medium text-blue-600">All Centars</span>
                            </div>
                            @foreach($centars as $centar)
                                <div class="p-2 hover:bg-blue-50 cursor-pointer centar-option {{ $selectedCentar == $centar->id ? 'bg-blue-100' : '' }}"
                                     data-value="{{ $centar->id }}"
                                     data-title="{{ strtolower($centar->title) }}"
                                     onclick="selectCentar('{{ $centar->id }}', '{{ addslashes($centar->title) }}')">
                                    <span class="text-gray-800">{{ $centar->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Total Votes -->
        <div class="mb-8 text-center">
            <div class="inline-block bg-white rounded-lg shadow-lg px-8 py-4">
                <p class="text-sm text-gray-600 mb-1">Total Votes Cast</p>
                <p class="text-4xl font-bold text-blue-600">{{ number_format($totalVotes) }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-8">
            <div class="flex space-x-4 border-b border-gray-200">
                <button onclick="showTab('overall')" id="overallTab"
                        class="tab-button px-6 py-3 font-semibold text-blue-600 border-b-2 border-blue-600">
                    Overall Results
                </button>
                <button onclick="showTab('centar')" id="centarTab"
                        class="tab-button px-6 py-3 font-semibold text-gray-500 hover:text-gray-700">
                    Centar-wise Results
                </button>
            </div>
        </div>

        <!-- Overall Results Tab -->
        <div id="overallContent" class="tab-content space-y-6">
            @forelse($overallResults as $index => $result)
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

        <!-- Centar-wise Results Tab -->
        <div id="centarContent" class="tab-content hidden space-y-8">
            @forelse($centarResults as $centarData)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Centar Header -->
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold mb-1">{{ $centarData['centar']->title }}</h2>
                                @if($centarData['centar']->address)
                                    <p class="text-purple-100">{{ $centarData['centar']->address }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-purple-100">Total Votes</p>
                                <p class="text-3xl font-bold">{{ number_format($centarData['total_votes']) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Centar Results -->
                    <div class="p-6 space-y-4">
                        @foreach($centarData['results'] as $index => $result)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <!-- Rank -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold
                                        {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                        {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                        {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                        {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }}">
                                        #{{ $index + 1 }}
                                    </div>
                                </div>

                                <!-- Marka Image -->
                                <div class="flex-shrink-0">
                                    @if($result->marka->image)
                                        <img src="{{ asset('storage/' . $result->marka->image) }}"
                                             alt="{{ $result->marka->title }}"
                                             class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Marka Info -->
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $result->marka->title }}</h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xl font-bold text-blue-600">{{ number_format($result->total_votes) }}</span>
                                        <span class="text-gray-600">votes</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $result->percentage }}%
                                        </span>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full transition-all duration-500"
                                             style="width: {{ $result->percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Centar Results Available</h3>
                    <p class="text-gray-600">Centar results will appear here once voting data is uploaded.</p>
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
    // Toggle centar dropdown
    function toggleCentarDropdown() {
        const dropdown = document.getElementById('centarDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('centarDropdown');
        const searchInput = document.getElementById('centar_search');
        if (!dropdown.contains(event.target) && event.target !== searchInput) {
            dropdown.classList.add('hidden');
        }
    });

    // Select centar
    function selectCentar(value, title) {
        document.getElementById('centar_id').value = value;
        document.getElementById('centar_search').value = title;
        document.getElementById('centarDropdown').classList.add('hidden');
        document.getElementById('filterForm').submit();
    }

    // Filter centars based on search input
    function filterCentars() {
        const searchInput = document.getElementById('centar_search');
        const dropdown = document.getElementById('centarDropdown');
        const filter = searchInput.value.toLowerCase();
        const options = dropdown.querySelectorAll('.centar-option');

        dropdown.classList.remove('hidden');

        options.forEach(option => {
            const title = option.getAttribute('data-title');
            if (title.includes(filter)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }

    // Tab switching
    function showTab(tabName) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active styling from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            button.classList.add('text-gray-500');
        });

        // Show selected content and activate tab
        if (tabName === 'overall') {
            document.getElementById('overallContent').classList.remove('hidden');
            document.getElementById('overallTab').classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            document.getElementById('overallTab').classList.remove('text-gray-500');
        } else if (tabName === 'centar') {
            document.getElementById('centarContent').classList.remove('hidden');
            document.getElementById('centarTab').classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            document.getElementById('centarTab').classList.remove('text-gray-500');
        }

        // Store active tab in localStorage
        localStorage.setItem('activeTab', tabName);
    }

    // Restore active tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = localStorage.getItem('activeTab') || 'overall';
        showTab(activeTab);

        // Set initial search value if centar is selected
        const selectedOption = document.querySelector('#centar_id option:checked');
        if (selectedOption && selectedOption.value) {
            document.getElementById('centar_search').value = selectedOption.text;
        }
    });

    // Auto-refresh every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection
