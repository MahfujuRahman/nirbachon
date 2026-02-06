@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Ashons -->
    {{-- <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Ashons</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_ashons'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Total Centars -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Centars</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_centars'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Markas -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Markas</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_markas'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Agents -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Agents</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_agents'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Results -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Results</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_results'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.results.index') }}" class="block p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-center transition">
                <p class="font-medium text-blue-700">See Results</p>
            </a>
            <a href="{{ route('admin.centars.import') }}" class="block p-4 bg-green-50 hover:bg-green-100 rounded-lg text-center transition">
                <p class="font-medium text-green-700">Import Centars</p>
            </a>
            <a href="{{ route('admin.markas.create') }}" class="block p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-center transition">
                <p class="font-medium text-yellow-700">Create Marka</p>
            </a>
            <a href="{{ route('admin.users.create') }}" class="block p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-center transition">
                <p class="font-medium text-purple-700">Create Agent</p>
            </a>
        </div>
    </div>
</div>
@endsection
