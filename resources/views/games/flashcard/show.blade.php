@extends('layouts.game')

@section('content')
<div class="bg-gradient-to-b from-indigo-50 to-blue-100 min-h-screen py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Game Header with Fun Elements -->
        <div class="mb-6 bg-white rounded-xl shadow-lg p-4 flex flex-col sm:flex-row justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-indigo-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $game->title }}</h1>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 px-3 py-2 rounded-lg">
                    <span class="text-sm font-medium text-blue-800">Card <span id="currentCard" class="text-xl font-bold">1</span> / <span id="totalCards" class="text-xl font-bold">0</span></span>
                </div>
                <div class="bg-green-100 px-3 py-2 rounded-lg">
                    <span class="text-sm font-medium text-green-800">Correct <span id="correctCount" class="text-xl font-bold">0</span></span>
                </div>
            </div>
        </div>

        <!-- Flashcard Container -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <!-- Instructions -->
            <div class="mb-4 text-center text-sm text-gray-600">
                <span class="inline-flex items-center bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tap the card to flip it!
                </span>
            </div>
            
            <!-- Card Container with Animation -->
            <div class="relative w-full" style="padding-bottom: 60%">
                <div id="flashcard" class="absolute top-0 left-0 w-full h-full cursor-pointer transition-all duration-200 hover:shadow-xl">
                    <div class="flashcard-inner w-full h-full">
                        <div class="flashcard-front">
                            <div id="cardFrontContent" class="text-center text-xl md:text-2xl font-medium">
                                <!-- Front Content -->
                            </div>
                        </div>
                        <div class="flashcard-back">
                            <div id="cardBackContent" class="text-center text-xl md:text-2xl font-medium">
                                <!-- Back Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-center space-x-4">
                <button id="prevCard" class="nav-button secondary group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </button>
                <button id="nextCard" class="nav-button primary group">
                    Next
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Assessment Section -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">How well did you know this?</h2>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <button class="assessment-btn btn-red group" data-rating="1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Didn't Know
                </button>
                <button class="assessment-btn btn-yellow group" data-rating="2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Partially
                </button>
                <button class="assessment-btn btn-green group" data-rating="3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Knew It!
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Card flipping styles */
    #flashcard {
        perspective: 1000px;
    }

    .flashcard-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 16px;
    }

    #flashcard.flipped .flashcard-inner {
        transform: rotateY(180deg);
    }

    .flashcard-front,
    .flashcard-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 16px;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .flashcard-front {
        background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
        border: 2px solid #e2e8f0;
    }

    .flashcard-back {
        background: linear-gradient(135deg, #ffffff 0%, #eff8ff 100%);
        border: 2px solid #bfdbfe;
        transform: rotateY(180deg);
    }

    /* Button styling */
    .nav-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .nav-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .nav-button:active {
        transform: translateY(1px);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .nav-button.primary {
        background-color: #4F46E5;
        color: white;
    }

    .nav-button.primary:hover {
        background-color: #4338CA;
    }

    .nav-button.secondary {
        background-color: #f3f4f6;
        color: #374151;
    }

    .nav-button.secondary:hover {
        background-color: #e5e7eb;
    }

    .assessment-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        padding: 10px 16px;
        font-weight: 500;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        opacity: 0.85;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .assessment-btn:hover {
        opacity: 1;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .assessment-btn:active {
        transform: translateY(1px);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .assessment-btn.selected {
        opacity: 1;
        font-weight: 600;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-red {
        background-color: #FEE2E2;
        color: #B91C1C;
    }
    
    .btn-red:hover {
        background-color: #FEE2E2;
    }
    
    .btn-yellow {
        background-color: #FEF3C7;
        color: #B45309;
    }
    
    .btn-yellow:hover {
        background-color: #FEF3C7;
    }
    
    .btn-green {
        background-color: #D1FAE5;
        color: #047857;
    }
    
    .btn-green:hover {
        background-color: #D1FAE5;
    }

    /* Animation for card flipping hint */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    #flashcard:not(.flipped) .flashcard-inner {
        animation: pulse 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        const flashcardGame = {
            cards: [],
            currentIndex: 0,
            correctCount: 0,
            isFlipped: false,

            init() {
                this.loadCards();
                this.setupEventListeners();
                this.updateUI();
                console.log("Flashcard game initialized");
            },

            loadCards() {
                // Load cards from the game content
                this.cards = {!! json_encode($game->content['cards'] ?? []) !!};
                console.log("Loaded cards:", this.cards);
                
                // Set default cards if none are available
                if (this.cards.length === 0) {
                    this.cards = [
                        { front: 'Sample Front 1', back: 'Sample Back 1' },
                        { front: 'Sample Front 2', back: 'Sample Back 2' }
                    ];
                }
                
                $('#totalCards').text(this.cards.length);
            },

            setupEventListeners() {
                // Flip card on click
                $('#flashcard').on('click', () => this.flipCard());
                
                // Navigation buttons
                $('#prevCard').on('click', () => this.prevCard());
                $('#nextCard').on('click', () => this.nextCard());
                
                // Assessment buttons
                $('.assessment-btn').on('click', (e) => {
                    const rating = parseInt($(e.currentTarget).data('rating'));
                    this.assessCard(rating);
                });
                
                console.log("Event listeners set up");
            },

            flipCard() {
                this.isFlipped = !this.isFlipped;
                $('#flashcard').toggleClass('flipped');
                console.log("Card flipped:", this.isFlipped);
            },

            updateCardContent() {
                const card = this.cards[this.currentIndex];
                console.log("Updating card content for index:", this.currentIndex, card);
                
                if (!card) {
                    console.error("No card found at index:", this.currentIndex);
                    return;
                }
                
                $('#cardFrontContent').html(card.front);
                $('#cardBackContent').html(card.back);
            },

            prevCard() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.isFlipped = false;
                    $('#flashcard').removeClass('flipped');
                    this.updateUI();
                    console.log("Moved to previous card:", this.currentIndex);
                }
            },

            nextCard() {
                if (this.currentIndex < this.cards.length - 1) {
                    this.currentIndex++;
                    this.isFlipped = false;
                    $('#flashcard').removeClass('flipped');
                    this.updateUI();
                    console.log("Moved to next card:", this.currentIndex);
                }
            },

            assessCard(rating) {
                console.log("Card assessed with rating:", rating);
                
                if (rating === 3) {
                    this.correctCount++;
                    $('#correctCount').text(this.correctCount);
                }

                $('.assessment-btn').removeClass('selected');
                $(`.assessment-btn[data-rating="${rating}"]`).addClass('selected');

                setTimeout(() => {
                    if (this.currentIndex < this.cards.length - 1) {
                        this.nextCard();
                    }
                }, 1000);
            },

            updateUI() {
                $('#currentCard').text(this.currentIndex + 1);
                this.updateCardContent();
                $('.assessment-btn').removeClass('selected');
                console.log("UI updated");
            }
        };

        // Initialize the game
        flashcardGame.init();
    });
</script>
@endpush
@endsection 