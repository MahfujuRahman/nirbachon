@extends('layouts.admin')

@section('header', 'Results Management')

@section('content')
<div class="bg-white shadow-lg rounded-lg">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Filter Results</h3>

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.results.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="ashon_id" class="block text-sm font-medium text-gray-700 mb-1">Ashon</label>
                <select name="ashon_id" id="ashon_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Ashons</option>
                    @foreach($ashons as $ashon)
                        <option value="{{ $ashon->id }}" {{ request('ashon_id') == $ashon->id ? 'selected' : '' }}>
                            {{ $ashon->title }}
                        </option>
                    @endforeach
                </select>
            </div>

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

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="p-4 md:p-6">
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
    </div>
</div>
@endsection
