@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    {{-- <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Educational Games</h1> --}}
    <!-- Add New Title -->
    <h1 class="text-4xl font-bold text-center text-blue-600 dark:text-blue-400 mb-10">Let's Play Some Kid Games!</h1>
    <!-- End New Title -->

    <div class="grid grid-cols-1 gap-y-12"> <!-- Increased vertical gap -->
        <!-- Flashcards Section -->
        @if($games->has('flashcard'))
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Flashcards</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($games['flashcard'] as $game)
                <a href="{{ route('games.show', $game) }}" 
                   class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $game->title }}</h3>
                            <span class="text-3xl">🎴</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $game->description }}</p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $game->plays }} plays</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Math Games Section -->
        @if($games->has('math'))
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Math Adventure</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($games['math'] as $game)
                <a href="{{ route('games.show', $game) }}"
                   class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $game->title }}</h3>
                            <span class="text-3xl">🔢</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $game->description }}</p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $game->plays }} plays</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Coloring Games Section -->
        @if($games->has('coloring'))
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Coloring & Drawing</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($games['coloring'] as $game)
                <a href="{{ route('games.show', $game) }}"
                   class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $game->title }}</h3>
                            <span class="text-3xl">🎨</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $game->description }}</p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $game->plays }} plays</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if($games->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 dark:text-gray-400 text-lg">No games available yet. Check back soon!</p>
        </div>
        @endif
    </div>
</div>
@endsection 