<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('animeaux.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Retour aux catégories
                </a>
            </div>

            <h1 class="text-4xl font-bold mb-8 text-blue-600 capitalize">Les {{ $type }}s</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($animaux as $animal)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-200">
                        <img src="{{ asset($animal->image_path) }}" 
                             alt="{{ $animal->nom }}"
                             class="w-full h-48 object-cover">
                        
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2">{{ $animal->nom }}</h2>
                            <p class="text-gray-600 text-sm italic mb-3">{{ $animal->espece }}</p>
                            <p class="text-gray-700">{{ $animal->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout> 