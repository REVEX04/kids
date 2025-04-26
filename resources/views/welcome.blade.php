@extends('layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">Welcome to Kids Reading!</h1>
        <p class="text-xl text-gray-600">Discover amazing stories and learn something new every day!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Albums et histoires -->
        <a href="{{ route('categories.show', 'albums-et-histoires') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-blue-500">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">📚</span>
                    <h2 class="text-2xl font-bold">Albums et histoires</h2>
                </div>
                <p class="text-white/90">Découvrez des histoires magnifiquement illustrées</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>

        <!-- Fables et poésies -->
        <a href="{{ route('categories.show', 'fables-et-poesies') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-green-500">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">📖</span>
                    <h2 class="text-2xl font-bold">Fables et poésies</h2>
                </div>
                <p class="text-white/90">Des fables classiques et poèmes pour enfants</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>

        <!-- Documentaires -->
        <a href="{{ route('categories.show', 'documentaires') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-purple-500">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">🔍</span>
                    <h2 class="text-2xl font-bold">Documentaires</h2>
                </div>
                <p class="text-white/90">Apprenez en vous amusant</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>

        <!-- Contes et légendes -->
        <a href="{{ route('categories.show', 'contes-et-legendes') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-orange-500">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">🏰</span>
                    <h2 class="text-2xl font-bold">Contes et légendes</h2>
                </div>
                <p class="text-white/90">Des histoires magiques et merveilleuses</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>

        <!-- Comptines et chansons -->
        <a href="{{ route('categories.show', 'comptines-et-chansons') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-green-500">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">🎵</span>
                    <h2 class="text-2xl font-bold">Comptines et chansons</h2>
                </div>
                <p class="text-white/90">Chantez et dansez avec vos chansons préférées</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>

        <!-- English Stories -->
        <a href="{{ route('categories.show', 'english-stories') }}" 
           class="block p-6 rounded-lg shadow-lg transition-transform hover:transform hover:scale-105 bg-blue-600">
            <div class="text-white">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-4">🌍</span>
                    <h2 class="text-2xl font-bold">English Stories</h2>
                </div>
                <p class="text-white/90">Learn English with fun stories</p>
                <div class="mt-4 text-sm">3 stories</div>
            </div>
        </a>
    </div>
@endsection

@push('scripts')
<script>
    // Background image handler
    document.addEventListener('DOMContentLoaded', function() {
        const bgImageInput = document.getElementById('bgImage');
        
        // Use the background image from the public directory
        const backgroundImagePath = "{{ asset('images/Background/nature-landscape-illustration-with-a-cute-and-colorful-design-suitable-for-kids-background-free-vector.jpg') }}";
        
        // Don't try to access local files directly anymore - use public assets
        document.body.style.backgroundImage = `url('${backgroundImagePath}')`;
        
        // Handle file selection
        bgImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.body.style.backgroundImage = `url('${e.target.result}')`;
                    document.body.style.backgroundSize = 'cover';
                    document.body.style.backgroundPosition = 'center';
                    document.body.style.backgroundAttachment = 'fixed';
                    
                    // Store in local storage to persist across page refreshes
                    localStorage.setItem('backgroundImage', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Check if we have a saved background
        const savedBg = localStorage.getItem('backgroundImage');
        if (savedBg) {
            document.body.style.backgroundImage = `url('${savedBg}')`;
            document.body.style.backgroundSize = 'cover';
            document.body.style.backgroundPosition = 'center';
            document.body.style.backgroundAttachment = 'fixed';
        }
    });
</script>
@endpush
