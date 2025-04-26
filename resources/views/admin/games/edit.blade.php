@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Game: {{ $game->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.games.content', $game) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm transition-colors">
                Manage Content
            </a>
            <a href="{{ route('admin.games.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm transition-colors">
                Back to Games
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form action="{{ route('admin.games.update', $game) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $game->title) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              required>{{ old('description', $game->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Game Type (readonly) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Game Type</label>
                    <div class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-500">
                        {{ $game->getTypeDisplayName() }}
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Game type cannot be changed after creation.</p>
                </div>

                <!-- Published Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" 
                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_published', $game->is_published) ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-gray-700">
                        Published
                    </label>
                </div>

                <!-- Game Stats -->
                <div class="bg-gray-50 rounded-md p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Game Statistics</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Total Plays:</span> {{ $game->plays }}
                        </div>
                        <div>
                            <span class="font-medium">Created:</span> {{ $game->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm transition-colors">
                        Update Game
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 