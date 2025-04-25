@extends('layouts.admin')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add New Story</h2>
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

            <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a category</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" required
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label for="age_range" class="block text-sm font-medium text-gray-700">Age Range</label>
                    <input type="text" name="age_range" id="age_range" value="{{ old('age_range') }}" required placeholder="e.g., 5-8 years"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="reading_time" class="block text-sm font-medium text-gray-700">Reading Time (minutes)</label>
                    <input type="number" name="reading_time" id="reading_time" value="{{ old('reading_time') }}" required min="1"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full shadow-sm sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Upload an image file or use an image URL below</p>
                </div>

                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">Enter a direct link to an image (will be used if no file is uploaded)</p>
                </div>

                <!-- Audio Upload Field -->
                <div>
                    <label for="audio_file" class="block text-sm font-medium text-gray-700">Audio File</label>
                    <input type="file" name="audio_file" id="audio_file" accept="audio/*"
                           class="mt-1 block w-full shadow-sm sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Upload an audio file (MP3, WAV, OGG)</p>
                </div>

                <div>
                    <label for="audio_duration" class="block text-sm font-medium text-gray-700">Audio Duration (seconds)</label>
                    <input type="number" name="audio_duration" id="audio_duration" value="{{ old('audio_duration') }}" min="1"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Video Upload Field -->
                <div>
                    <label for="video_file" class="block text-sm font-medium text-gray-700">Video File</label>
                    <input type="file" name="video_file" id="video_file" accept="video/*"
                           class="mt-1 block w-full shadow-sm sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Upload a video file (MP4, WebM, OGG)</p>
                </div>

                <div>
                    <label for="video_duration" class="block text-sm font-medium text-gray-700">Video Duration (seconds)</label>
                    <input type="number" name="video_duration" id="video_duration" value="{{ old('video_duration') }}" min="1"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Story
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 