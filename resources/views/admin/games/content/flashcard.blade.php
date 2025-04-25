@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Manage Flashcards: {{ $game->title }}</h1>
        <a href="{{ route('admin.games.edit', $game) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Back to Game
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Game Settings Form -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Game Settings</h2>
        <form action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="update_type" value="settings"> <!-- Identifier for the controller -->

            <div>
                <label class="flex items-center">
                    <input type="hidden" name="content[settings][showProgress]" value="0"> <!-- Unchecked value -->
                    <input type="checkbox" name="content[settings][showProgress]" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                           {{ old('content.settings.showProgress', $game->content['settings']['show_progress'] ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Show Progress Bar in Game</span>
                </label>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="hidden" name="content[settings][shuffleCards]" value="0"> <!-- Unchecked value -->
                    <input type="checkbox" name="content[settings][shuffleCards]" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                           {{ old('content.settings.shuffleCards', $game->content['settings']['shuffle_cards'] ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Shuffle Cards Order</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Manage Cards Section -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Manage Cards</h2>
            <!-- Add Card Button -->
            <button type="button" id="addCardBtn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Card
            </button>
        </div>

        <!-- Cards Form -->
        <form id="cardsForm" action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="update_type" value="cards"> <!-- Identifier for the controller -->

            <div id="cardsContainer" class="space-y-6">
                <!-- Existing cards will be loaded here -->
                @forelse($game->content['cards'] ?? [] as $index => $card)
                <div class="card-item border rounded-lg p-4 bg-gray-50 transition-all duration-300 ease-in-out" data-index="{{ $index }}">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-md font-medium text-gray-900">Card <span class="card-number">{{ $index + 1 }}</span></h3>
                        <button type="button" class="remove-card-btn text-red-600 hover:text-red-800 transition-colors">
                            <svg class="h-5 w-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="card-front-{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">Front Content</label>
                            <textarea id="card-front-{{ $index }}" name="content[cards][{{ $index }}][front]" rows="3" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter front content (text or image URL)">{{ $card['front'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="card-back-{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">Back Content</label>
                            <textarea id="card-back-{{ $index }}" name="content[cards][{{ $index }}][back]" rows="3" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter back content (text or image URL)">{{ $card['back'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @empty
                <p id="noCardsMessage" class="text-center text-gray-500 py-4">No cards added yet. Click 'Add New Card' to begin.</p>
                @endforelse
            </div>

            <!-- Save Cards Button -->
            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save All Cards
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Template for new cards (hidden) -->
<template id="cardTemplate">
    <div class="card-item border rounded-lg p-4 bg-gray-100 opacity-0 transform scale-95 transition-all duration-300 ease-in-out" data-index="__INDEX__">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-md font-medium text-gray-900">Card <span class="card-number">__NUMBER__</span></h3>
            <button type="button" class="remove-card-btn text-red-600 hover:text-red-800 transition-colors">
                <svg class="h-5 w-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="card-front-__INDEX__" class="block text-sm font-medium text-gray-700 mb-1">Front Content</label>
                <textarea id="card-front-__INDEX__" name="content[cards][__INDEX__][front]" rows="3" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter front content (text or image URL)"></textarea>
            </div>
            <div>
                <label for="card-back-__INDEX__" class="block text-sm font-medium text-gray-700 mb-1">Back Content</label>
                <textarea id="card-back-__INDEX__" name="content[cards][__INDEX__][back]" rows="3" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter back content (text or image URL)"></textarea>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('[FlashcardAdmin] DOM Loaded, initializing script.'); // Log: Script start
        
        const cardsContainer = document.getElementById('cardsContainer');
        const addCardBtn = document.getElementById('addCardBtn');
        const cardTemplate = document.getElementById('cardTemplate');
        const noCardsMessage = document.getElementById('noCardsMessage');

        if (!cardsContainer) console.error('[FlashcardAdmin] Cards container not found!');
        if (!addCardBtn) console.error('[FlashcardAdmin] Add Card button not found!');
        if (!cardTemplate) console.error('[FlashcardAdmin] Card template not found!');

        function updateCardNumbers() {
            console.log('[FlashcardAdmin] updateCardNumbers function called.'); // Log: Function start
            
            const cards = cardsContainer.querySelectorAll('.card-item');
            cards.forEach((card, index) => {
                card.querySelector('.card-number').textContent = index + 1;
                card.dataset.index = index;
                const frontLabel = card.querySelector('label[for^="card-front-"]');
                const frontTextarea = card.querySelector('textarea[id^="card-front-"]');
                const backLabel = card.querySelector('label[for^="card-back-"]');
                const backTextarea = card.querySelector('textarea[id^="card-back-"]');
                if (frontLabel) frontLabel.setAttribute('for', `card-front-${index}`);
                if (frontTextarea) {
                    frontTextarea.id = `card-front-${index}`;
                    frontTextarea.name = `content[cards][${index}][front]`;
                }
                if (backLabel) backLabel.setAttribute('for', `card-back-${index}`);
                if (backTextarea) {
                    backTextarea.id = `card-back-${index}`;
                    backTextarea.name = `content[cards][${index}][back]`;
                }
            });
            if (noCardsMessage) {
                noCardsMessage.style.display = cards.length === 0 ? 'block' : 'none';
            }
            // console.log('[FlashcardAdmin] Card numbers updated.'); // Optional log
        }

        function addNewCard() {
            console.log('[FlashcardAdmin] addNewCard function called.'); // Log: Function start
            
            if (!cardTemplate) {
                console.error('[FlashcardAdmin] Card template not found inside addNewCard!');
                return;
            }
            console.log('[FlashcardAdmin] Card template found.'); // Log: Template OK
            
            if (!cardsContainer) {
                console.error('[FlashcardAdmin] Cards container not found inside addNewCard!');
                return;
            }
            console.log('[FlashcardAdmin] Cards container found.'); // Log: Container OK

            const index = cardsContainer.querySelectorAll('.card-item').length;
            console.log(`[FlashcardAdmin] New card index will be: ${index}`); // Log: Index
            
            const newCardHTML = cardTemplate.innerHTML
                                    .replace(/__INDEX__/g, index)
                                    .replace(/__NUMBER__/g, index + 1);
            console.log('[FlashcardAdmin] Template HTML processed.'); // Log: Template processed
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newCardHTML.trim();
            const newCardElement = tempDiv.firstChild;
            
            if (!newCardElement) {
                 console.error('[FlashcardAdmin] Failed to create new card element from template HTML.');
                 return;
            }
            console.log('[FlashcardAdmin] New card element created:', newCardElement); // Log: Element created

            cardsContainer.appendChild(newCardElement);
            console.log('[FlashcardAdmin] New card appended to container.'); // Log: Appended
            
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    newCardElement.classList.remove('opacity-0', 'scale-95');
                    console.log('[FlashcardAdmin] Animation triggered.'); // Log: Animation
                });
            });
            
            const removeBtn = newCardElement.querySelector('.remove-card-btn');
            if(removeBtn) {
                removeBtn.addEventListener('click', removeCard);
                console.log('[FlashcardAdmin] Remove button listener added.'); // Log: Remove listener
            } else {
                 console.warn('[FlashcardAdmin] Could not find remove button in new card element.');
            }
            
            updateCardNumbers();
            
            const firstTextarea = newCardElement.querySelector('textarea');
            if (firstTextarea) {
                firstTextarea.focus();
                console.log('[FlashcardAdmin] Focused first textarea.'); // Log: Focus
            }
        }

        function removeCard(event) {
             console.log('[FlashcardAdmin] removeCard function called.'); // Log: Remove start
            const cardItem = event.target.closest('.card-item');
            if (cardItem) {
                cardItem.classList.add('opacity-0', 'scale-90');
                cardItem.style.height = cardItem.offsetHeight + 'px';
                console.log('[FlashcardAdmin] Initiating card removal animation.'); // Log: Remove anim
                
                setTimeout(() => {
                    cardItem.remove();
                    console.log('[FlashcardAdmin] Card element removed from DOM.'); // Log: Removed
                    updateCardNumbers();
                }, 300); 
            }
        }

        // --- Event Listeners ---
        if (addCardBtn && cardsContainer && cardTemplate) {
             console.log('[FlashcardAdmin] Attaching click listener to Add Card button.'); // Log: Attaching listener
            addCardBtn.addEventListener('click', addNewCard);
        } else {
            console.error('[FlashcardAdmin] Could not attach listener - button, container, or template missing.');
        }

        // Add event listeners to existing remove buttons
        cardsContainer.querySelectorAll('.remove-card-btn').forEach(button => {
            console.log('[FlashcardAdmin] Attaching listener to existing remove button.'); // Log: Attaching remove listeners
            button.addEventListener('click', removeCard);
        });

        // Initial check for the 'no cards' message
        updateCardNumbers();
        console.log('[FlashcardAdmin] Script initialization complete.'); // Log: Script end
        
    });
</script>
@endpush 