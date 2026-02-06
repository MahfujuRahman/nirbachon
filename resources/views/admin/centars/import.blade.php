@extends('layouts.admin')

@section('header', 'Import Centars')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-4 md:px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Import Centars from CSV/Excel</h3>
        </div>
        <div class="p-4 md:p-6">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">CSV/Excel Format</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p class="mb-2">The file should have one centar per line with the following format:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li><strong>Title</strong> (required) - The name of the centar</li>
                                <li><strong>Address</strong> (optional) - If included, separate with a comma</li>
                            </ul>
                            <div class="mt-3 bg-white p-2 rounded border border-blue-200">
                                <p class="font-semibold mb-1">Examples:</p>
                                <code class="text-xs block">আফতাবনগর উচ্চ বিদ্যালয়</code>
                                <code class="text-xs block mt-1">আফতাবনগর উচ্চ বিদ্যালয়, আফতাবনগর</code>
                            </div>
                            <p class="mt-2 text-xs">• All centars will be assigned to Ashon ID: 1</p>
                            <p class="text-xs">• Duplicate titles will be skipped automatically</p>
                            <p class="text-xs">• Leading numbers will be removed from titles</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.centars.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('file') border-red-500 @enderror">
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Supported formats: .xlsx, .xls, .csv (Max: 10MB)</p>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('admin.centars.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                        Import Centars
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
