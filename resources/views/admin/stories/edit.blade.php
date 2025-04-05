@extends('layouts.admin')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Story</h2>
                <a href="{{ route('admin.stories.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Stories
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.stories.update', $story) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $story->title) }}" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $story->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" required
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('content', $story->content) }}</textarea>
                </div>

                <div>
                    <label for="age_range" class="block text-sm font-medium text-gray-700">Age Range</label>
                    <input type="text" name="age_range" id="age_range" value="{{ old('age_range', $story->age_range) }}" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="reading_time" class="block text-sm font-medium text-gray-700">Reading Time (minutes)</label>
                    <input type="number" name="reading_time" id="reading_time" value="{{ old('reading_time', $story->reading_time) }}" required min="1"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    @if($story->thumbnail)
                        <div class="mt-2 mb-4">
                            @if(filter_var($story->thumbnail, FILTER_VALIDATE_URL))
                                <img src="{{ $story->thumbnail }}?t={{ time() }}" alt="{{ $story->title }}" class="h-32 w-32 object-cover rounded">
                            @else
                                <img src="{{ asset('storage/' . $story->thumbnail) }}?t={{ time() }}" alt="{{ $story->title }}" class="h-32 w-32 object-cover rounded">
                            @endif
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full shadow-sm sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Upload an image file or use an image URL below</p>
                </div>

                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input type="url" name="image_url" id="image_url" 
                           value="{{ old('image_url', (filter_var($story->thumbnail, FILTER_VALIDATE_URL) ? $story->thumbnail : '')) }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">Enter a direct link to an image (will be used if no file is uploaded)</p>
                </div>

                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Story
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 