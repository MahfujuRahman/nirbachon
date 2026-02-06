@extends('layouts.app')

@section('title', 'Login - Nirbachon')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Nirbachon Voting Management System
                </p>
            </div>

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email address
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('email') border-red-500 @enderror"
                           placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                           placeholder="Enter your password">
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Default Admin: admin@nirbachon.com / password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
