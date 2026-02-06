<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Agent Panel - Nirbachon')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-4 space-y-3 sm:space-y-0">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h1>
                        <p class="text-xs md:text-sm text-gray-600">{{ auth()->user()->centar?->title ?? 'No Marka Assigned' }}</p>
                    </div>
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <a href="{{ route('agent.results.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 md:px-4 py-2 rounded-lg transition duration-200 text-sm md:text-base whitespace-nowrap">
                            Upload Result
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 md:px-4 py-2 rounded-lg transition duration-200 text-sm md:text-base">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
