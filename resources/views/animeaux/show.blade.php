<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <a href="{{ route('animeaux.index') }}" class="text-blue-500 hover:text-blue-700">
                            ← Retour aux catégories
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <img src="{{ Storage::url($animal->image_path) }}" 
                                 alt="{{ $animal->nom }}" 
                                 class="w-full h-auto rounded-lg shadow-lg">
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl font-bold text-gray-800">{{ $animal->nom }}</h1>
                            
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <p class="text-lg font-semibold text-blue-800">Espèce: {{ $animal->espece }}</p>
                                <p class="text-lg font-semibold text-blue-800">Type: {{ ucfirst($animal->type) }}</p>
                            </div>

                            <div class="prose max-w-none">
                                <h2 class="text-2xl font-bold text-gray-700 mb-2">Description</h2>
                                <p class="text-gray-600 text-lg leading-relaxed">
                                    {{ $animal->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 