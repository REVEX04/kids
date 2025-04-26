<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('animeaux.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Retour aux catégories
                </a>
            </div>

            <h1 class="text-4xl font-bold mb-8 text-center text-blue-600">
                Les {{ ucfirst($type) }}s
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($animaux as $animal)
                    <a href="{{ route('animeaux.show', $animal) }}" 
                       class="transform hover:scale-105 transition-all duration-200">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-200">
                            <div class="relative h-48">
                                <img src="{{ Storage::url($animal->image_path) }}" 
                                     alt="{{ $animal->nom }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h2 class="text-xl font-bold text-gray-800">{{ $animal->nom }}</h2>
                                <p class="text-gray-600 mt-2">{{ Str::limit($animal->description, 100) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $animaux->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 