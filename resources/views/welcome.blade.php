@extends('layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">Welcome to Kids Reading!</h1>
        <p class="text-xl text-gray-600">Discover amazing stories and learn something new every day!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" 
               class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105"
               style="background-color: {{ $category->color }}">
                <div class="text-white">
                    <div class="flex items-center mb-4">
                        @if($category->icon)
                            <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="w-12 h-12 mr-4">
                        @endif
                        <h2 class="text-2xl font-bold">{{ $category->name }}</h2>
                    </div>
                    <p class="text-white/90">{{ $category->description }}</p>
                    <div class="mt-4 text-sm">
                        {{ $category->stories_count }} stories
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
