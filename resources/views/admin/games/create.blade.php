@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create New Game</h1>
        <a href="{{ route('admin.games.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm transition-colors">
            Back to Games
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form action="{{ route('admin.games.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
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
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Game Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Game Type</label>
                    <select name="type" id="type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                        <option value="">Select a type</option>
                        @foreach($gameTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" 
                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_published') ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-gray-700">
                        Publish immediately
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm transition-colors">
                        Create Game
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 