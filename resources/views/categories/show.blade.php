@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">{{ $category->name }}</h1>
        <p class="text-xl text-gray-600">{{ $category->description }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($stories as $story)
            <a href="{{ route('stories.show', $story) }}" 
               class="block bg-white p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105">
                @if($story->thumbnail)
                    @if(filter_var($story->thumbnail, FILTER_VALIDATE_URL))
                        <img src="{{ $story->thumbnail }}" 
                             alt="{{ $story->title }}" 
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <img src="{{ asset('storage/' . $story->thumbnail) }}" 
                             alt="{{ $story->title }}" 
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif
                @endif
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $story->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($story->description, 100) }}</p>
                <div class="flex justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        {{ number_format($story->rating, 1) }}
                    </div>
                    <div>{{ $story->views }} views</div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $stories->links() }}
    </div>
@endsection 