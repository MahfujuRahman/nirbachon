@extends('layouts.app')

@section('title', 'Live Results - Nirbachon')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-6 md:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2 md:mb-4 px-2">Live Voting Results</h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 px-2">Real-time election results</p>
        </div>

        <!-- Filters -->
        <div class="mb-4 md:mb-8 bg-white rounded-lg shadow-lg p-3 md:p-4">
            <form method="GET" action="{{ route('home') }}" id="filterForm" class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3 md:gap-4">
                @if($ashons->count() > 1)
                    <div class="flex-1 w-full sm:min-w-[200px]">
                        <label for="ashon_id" class="text-xs sm:text-sm font-medium text-gray-700 mb-1 block">Filter by Ashon:</label>
                        <select name="ashon_id" id="ashon_id" onchange="document.getElementById('filterForm').submit()"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">All Ashons</option>
                            @foreach($ashons as $ashon)
                                <option value="{{ $ashon->id }}" {{ $selectedAshon == $ashon->id ? 'selected' : '' }}>
                                    {{ $ashon->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex-1 w-full sm:min-w-[200px]">
                    <label for="centar_search" class="text-xs sm:text-sm font-medium text-gray-700 mb-1 block">Search & Filter by Centar:</label>
                    <div class="relative">
                        <input type="text" id="centar_search" placeholder="Type to search centars..."
                               class="w-full px-3 sm:px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
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
                        <div id="centarDropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 sm:max-h-60 overflow-y-auto">
                            <div class="p-2 sm:p-2.5 hover:bg-blue-50 cursor-pointer border-b border-gray-200" onclick="selectCentar('', 'All Centars')">
                                <span class="font-medium text-blue-600 text-sm">All Centars</span>
                            </div>
                            @foreach($centars as $centar)
                                <div class="p-2 sm:p-2.5 hover:bg-blue-50 cursor-pointer centar-option {{ $selectedCentar == $centar->id ? 'bg-blue-100' : '' }}"
                                     data-value="{{ $centar->id }}"
                                     data-title="{{ strtolower($centar->title) }}"
                                     onclick="selectCentar('{{ $centar->id }}', '{{ addslashes($centar->title) }}')">
                                    <span class="text-gray-800 text-sm">{{ $centar->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Total Votes -->
        <div class="mb-4 md:mb-8 text-center">
            <div class="inline-block bg-white rounded-lg shadow-lg px-4 sm:px-6 md:px-8 py-3 md:py-4">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Votes Cast</p>
                <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-600">{{ number_format($totalVotes) }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-4 md:mb-8">
            <div class="flex space-x-2 sm:space-x-4 border-b border-gray-200 overflow-x-auto">
                <button onclick="showTab('overall')" id="overallTab"
                        class="tab-button px-3 sm:px-4 md:px-6 py-2 md:py-3 font-semibold text-sm sm:text-base text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                    Overall Results
                </button>
                <button onclick="showTab('centar')" id="centarTab"
                        class="tab-button px-3 sm:px-4 md:px-6 py-2 md:py-3 font-semibold text-sm sm:text-base text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Centar-wise Results
                </button>
            </div>
        </div>

        <!-- Overall Results Tab -->
        <div id="overallContent" class="tab-content space-y-3 md:space-y-4">
            @forelse($overallResults as $index => $result)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <!-- Mobile Layout -->
                    <div class="block md:hidden">
                        <!-- Header with rank and title -->
                        <div class="flex items-center gap-3 p-3 border-b border-gray-100">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-base font-bold
                                    {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                    {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                    {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                    {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }}">
                                    #{{ $index + 1 }}
                                </div>
                            </div>
                            <h3 class="flex-1 text-base font-bold text-gray-900 line-clamp-2">
                                {{ $result->marka->title }}
                            </h3>
                        </div>
                        <!-- Content -->
                        <div class="p-3">
                            <div class="flex items-start gap-3 mb-3">
                                @if($result->marka->image)
                                    <img src="{{ asset('storage/' . $result->marka->image) }}"
                                         alt="{{ $result->marka->title }}"
                                         class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200 flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-baseline gap-2 mb-2">
                                        <span class="text-2xl font-bold text-blue-600">
                                            {{ number_format($result->total_votes) }}
                                        </span>
                                        <span class="text-xs text-gray-600">votes</span>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $result->percentage }}%
                                    </span>
                                </div>
                            </div>
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500"
                                     style="width: {{ $result->percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop/Tablet Layout -->
                    <div class="hidden md:flex items-center gap-4 lg:gap-6 p-4 lg:p-5">
                        <!-- Rank Badge -->
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-full flex items-center justify-center text-xl lg:text-2xl font-bold
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
                                     class="w-20 h-20 lg:w-24 lg:h-24 object-cover rounded-lg border-4 border-gray-200">
                            @else
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Marka Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 mb-2">
                                {{ $result->marka->title }}
                            </h3>
                            <div class="flex items-center gap-4 mb-3">
                                <div>
                                    <span class="text-2xl lg:text-3xl font-bold text-blue-600">
                                        {{ number_format($result->total_votes) }}
                                    </span>
                                    <span class="text-gray-600 ml-2">votes</span>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $result->percentage }}%
                                </span>
                            </div>
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500"
                                     style="width: {{ $result->percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-6 sm:p-8 md:p-12 text-center">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">No Results Available</h3>
                    <p class="text-sm sm:text-base text-gray-600 px-4">Results will appear here once voting data is uploaded.</p>
                </div>
            @endforelse
        </div>

        <!-- Centar-wise Results Tab -->
        <div id="centarContent" class="tab-content hidden space-y-3 md:space-y-6">
            @forelse($centarResults as $centarData)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Centar Header -->
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-3 md:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <h2 class="text-base md:text-xl lg:text-2xl font-bold mb-1 line-clamp-2">{{ $centarData['centar']->title }}</h2>
                                @if($centarData['centar']->address)
                                    <p class="text-purple-100 text-xs md:text-sm line-clamp-1">{{ $centarData['centar']->address }}</p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs text-purple-100">Total</p>
                                <p class="text-lg md:text-2xl lg:text-3xl font-bold whitespace-nowrap">{{ number_format($centarData['total_votes']) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Centar Results -->
                    <div class="p-2.5 md:p-4 lg:p-5 space-y-2 md:space-y-3">
                        @foreach($centarData['results'] as $index => $result)
                            <!-- Mobile Layout -->
                            <div class="block md:hidden bg-gray-50 rounded-lg p-2.5 hover:bg-gray-100 transition">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                                        {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                        {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                        {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                        {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }}">
                                        #{{ $index + 1 }}
                                    </div>
                                    <h4 class="flex-1 text-sm font-bold text-gray-900 line-clamp-1">{{ $result->marka->title }}</h4>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    @if($result->marka->image)
                                        <img src="{{ asset('storage/' . $result->marka->image) }}"
                                             alt="{{ $result->marka->title }}"
                                             class="w-12 h-12 object-cover rounded-lg border-2 border-gray-200 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-baseline gap-2 mb-1.5">
                                            <span class="text-lg font-bold text-blue-600">{{ number_format($result->total_votes) }}</span>
                                            <span class="text-xs text-gray-600">votes</span>
                                            <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-semibold
                                                {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $result->percentage }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full transition-all duration-500"
                                                 style="width: {{ $result->percentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop/Tablet Layout -->
                            <div class="hidden md:flex items-center gap-3 lg:gap-4 p-3 lg:p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold
                                        {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                        {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                        {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                        {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }}">
                                        #{{ $index + 1 }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($result->marka->image)
                                        <img src="{{ asset('storage/' . $result->marka->image) }}"
                                             alt="{{ $result->marka->title }}"
                                             class="w-14 h-14 lg:w-16 lg:h-16 object-cover rounded-lg border-2 border-gray-200">
                                    @else
                                        <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base lg:text-lg font-bold text-gray-900 mb-1">{{ $result->marka->title }}</h4>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-lg lg:text-xl font-bold text-blue-600">{{ number_format($result->total_votes) }}</span>
                                        <span class="text-gray-600 text-sm">votes</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $result->percentage }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full transition-all duration-500"
                                             style="width: {{ $result->percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-6 sm:p-8 md:p-12 text-center">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">No Centar Results Available</h3>
                    <p class="text-sm sm:text-base text-gray-600 px-4">Centar results will appear here once voting data is uploaded.</p>
                </div>
            @endforelse
        </div>

        <!-- Auto Refresh Notice -->
        <div class="mt-4 md:mt-8 text-center px-4">
            <p class="text-xs sm:text-sm text-gray-600">
                <svg class="inline-block w-3 h-3 sm:w-4 sm:h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
