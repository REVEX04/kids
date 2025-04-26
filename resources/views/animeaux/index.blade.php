<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-8 text-blue-600">Découvre les Animaux ! 🦁</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $typeIcons = [
                        'mammifere' => '🦁',
                        'oiseau' => '🦅',
                        'reptile' => '🐊',
                        'amphibien' => '🐸',
                        'invertebré' => '🦋',
                        'poisson' => '🐠'
                    ];
                    
                    $typeColors = [
                        'mammifere' => 'bg-yellow-100 hover:bg-yellow-200 border-yellow-300',
                        'oiseau' => 'bg-blue-100 hover:bg-blue-200 border-blue-300',
                        'reptile' => 'bg-green-100 hover:bg-green-200 border-green-300',
                        'amphibien' => 'bg-emerald-100 hover:bg-emerald-200 border-emerald-300',
                        'invertebré' => 'bg-purple-100 hover:bg-purple-200 border-purple-300',
                        'poisson' => 'bg-cyan-100 hover:bg-cyan-200 border-cyan-300'
                    ];

                    $typeNames = [
                        'mammifere' => 'Mammifère',
                        'oiseau' => 'Oiseau',
                        'reptile' => 'Reptile',
                        'amphibien' => 'Amphibien',
                        'invertebré' => 'Invertébré',
                        'poisson' => 'Poisson'
                    ];
                @endphp

                @foreach($types as $type)
                    <a href="{{ route('animeaux.type', $type) }}" 
                       class="transform hover:scale-105 transition-all duration-200">
                        <div class="rounded-xl shadow-lg overflow-hidden {{ $typeColors[$type] }} border-2 p-6">
                            <div class="text-6xl mb-4 text-center">{{ $typeIcons[$type] }}</div>
                            <h2 class="text-2xl font-bold text-center">{{ $typeNames[$type] }}s</h2>
                            <p class="text-center mt-2 text-gray-600">Découvre les {{ strtolower($typeNames[$type]) }}s fascinants !</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout> 