@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <div class="mb-6">
            <a href="{{ route('categories.show', $story->category) }}" 
               class="text-blue-500 hover:text-blue-700 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to {{ $story->category->name }}
            </a>
        </div>

        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($story->thumbnail)
                <img src="{{ asset('storage/' . $story->thumbnail) }}" 
                     alt="{{ $story->title }}"
                     class="w-full h-64 object-cover">
            @endif

            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $story->title }}</h1>
                
                <div class="flex items-center space-x-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        {{ number_format($story->rating, 1) }}
                    </div>
                    <div>{{ $story->views }} views</div>
                    <div>{{ $story->created_at->format('M d, Y') }}</div>
                </div>

                <!-- Story Experience Selection -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8">
                    <h2 class="text-xl font-bold text-blue-800 mb-4">How would you like to enjoy this story?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Read button -->
                        <button id="read-btn" class="flex flex-col items-center justify-center bg-white hover:bg-blue-50 border-2 border-blue-200 rounded-xl p-4 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:bg-blue-100 active:border-blue-300">
                            <span class="text-3xl mb-2">📖</span>
                            <span class="font-semibold text-lg">Read</span>
                        </button>
                        
                        <!-- Listen button -->
                        @if($story->audio_file)
                        <button id="listen-btn" class="flex flex-col items-center justify-center bg-white hover:bg-blue-50 border-2 border-blue-200 rounded-xl p-4 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:bg-blue-100 active:border-blue-300">
                            <span class="text-3xl mb-2">🎧</span>
                            <span class="font-semibold text-lg">Listen & Read</span>
                        </button>
                        @endif
                        
                        <!-- Watch button -->
                        @if($story->video_file)
                        <button id="watch-btn" class="flex flex-col items-center justify-center bg-white hover:bg-blue-50 border-2 border-blue-200 rounded-xl p-4 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:bg-blue-100 active:border-blue-300">
                            <span class="text-3xl mb-2">🎬</span>
                            <span class="font-semibold text-lg">Watch</span>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Media sections (initially hidden) -->
                <div id="audio-section" class="hidden mb-6 bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg mb-3">Listen along as you read</h3>
                    @if($story->audio_file)
                    <audio id="story-audio" controls class="w-full">
                        <source src="{{ asset('storage/' . $story->audio_file) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    @endif
                </div>

                <div id="video-section" class="hidden mb-6 bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg mb-3">Watch the video story</h3>
                    @if($story->video_file)
                    <video id="story-video" controls class="w-full rounded">
                        <source src="{{ asset('storage/' . $story->video_file) }}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    @endif
                </div>

                <!-- Story Content -->
                <div id="story-content" class="prose max-w-none">
                    {!! $story->content !!}
                </div>
            </div>
        </article>

        <!-- Rating Section -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Rate this story</h2>
            <form action="{{ route('stories.rate', $story) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                <div class="flex items-center space-x-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="submit" name="rating" value="{{ $i }}" class="focus:outline-none">
                            <svg class="w-8 h-8 text-yellow-400 hover:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get elements
            const readBtn = document.getElementById('read-btn');
            const listenBtn = document.getElementById('listen-btn');
            const watchBtn = document.getElementById('watch-btn');
            
            const audioSection = document.getElementById('audio-section');
            const videoSection = document.getElementById('video-section');
            const storyContent = document.getElementById('story-content');
            const storyAudio = document.getElementById('story-audio');
            const storyVideo = document.getElementById('story-video');
            
            // Read button - just show content
            if (readBtn) {
                readBtn.addEventListener('click', function() {
                    // Hide media sections
                    audioSection.classList.add('hidden');
                    videoSection.classList.add('hidden');
                    
                    // Stop media if playing
                    if (storyAudio) storyAudio.pause();
                    if (storyVideo) storyVideo.pause();
                    
                    // Highlight active button
                    readBtn.classList.add('bg-blue-100', 'border-blue-300');
                    if (listenBtn) listenBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    if (watchBtn) watchBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    
                    // Scroll to content
                    storyContent.scrollIntoView({behavior: 'smooth'});
                });
            }
            
            // Listen button - show audio and content
            if (listenBtn) {
                listenBtn.addEventListener('click', function() {
                    // Show audio, hide video
                    audioSection.classList.remove('hidden');
                    videoSection.classList.add('hidden');
                    
                    // Stop video if playing
                    if (storyVideo) storyVideo.pause();
                    
                    // Highlight active button
                    listenBtn.classList.add('bg-blue-100', 'border-blue-300');
                    readBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    if (watchBtn) watchBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    
                    // Scroll to audio section
                    audioSection.scrollIntoView({behavior: 'smooth'});
                });
            }
            
            // Watch button - show video
            if (watchBtn) {
                watchBtn.addEventListener('click', function() {
                    // Show video, hide audio
                    videoSection.classList.remove('hidden');
                    audioSection.classList.add('hidden');
                    
                    // Stop audio if playing
                    if (storyAudio) storyAudio.pause();
                    
                    // Highlight active button
                    watchBtn.classList.add('bg-blue-100', 'border-blue-300');
                    readBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    if (listenBtn) listenBtn.classList.remove('bg-blue-100', 'border-blue-300');
                    
                    // Scroll to video section
                    videoSection.scrollIntoView({behavior: 'smooth'});
                });
            }
            
            // Set read as default
            if (readBtn) {
                readBtn.click();
            }
        });
    </script>
@endsection 