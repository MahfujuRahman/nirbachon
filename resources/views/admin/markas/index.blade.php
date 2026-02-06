@extends('layouts.admin')

@section('header', 'Markas')

@section('content')
<div class="bg-white shadow-lg rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold">Markas List</h3>
        <a href="{{ route('admin.markas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
            Add New Marka
        </a>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($markas as $marka)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="p-4">
                        @if($marka->image)
                            <img src="{{ asset('storage/' . $marka->image) }}" alt="{{ $marka->title }}" class="w-full h-48 object-cover rounded-lg mb-3">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $marka->title }}</h4>
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.markas.edit', $marka) }}" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.markas.destroy', $marka) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    No markas found.
                </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $markas->links() }}
        </div>
    </div>
</div>
@endsection
