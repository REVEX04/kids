@extends('layouts.game')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-teal-100 min-h-screen py-8 px-4 font-comic-sans">
    <div class="max-w-4xl mx-auto">
        <!-- Game Header with Fun Elements -->
        <div class="mb-6 bg-white rounded-xl shadow-lg p-4 flex flex-col sm:flex-row justify-between items-center border-4 border-green-300 border-dashed">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center mr-4 shadow-md transform -rotate-6 border-2 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $game->title }}</h1>
                    <p class="text-sm text-green-700 font-medium">Let's solve some puzzles!</p>
                </div>
            </div>
            
            <div class="flex flex-wrap justify-center gap-3 mt-4 sm:mt-0">
                <div class="stat-bubble bg-gradient-to-r from-green-200 to-green-300 border-green-400">
                    <svg class="w-5 h-5 mr-1 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span class="text-sm font-semibold text-green-900">Level <span id="currentLevel" class="text-xl font-bold">1</span></span>
                </div>
                <div class="stat-bubble bg-gradient-to-r from-blue-200 to-blue-300 border-blue-400">
                    <svg class="w-5 h-5 mr-1 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-semibold text-blue-900">Time <span id="timer" class="text-xl font-bold">60</span>s</span>
                </div>
                <div class="stat-bubble bg-gradient-to-r from-purple-200 to-purple-300 border-purple-400">
                    <svg class="w-5 h-5 mr-1 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span class="text-sm font-semibold text-purple-900">Points <span id="points" class="text-xl font-bold">0</span></span>
                </div>
            </div>
        </div>

        <!-- Math Question Container -->
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 border-4 border-green-300 relative overflow-hidden">
             <div class="absolute -top-5 -left-5 w-24 h-24 bg-yellow-200 rounded-full opacity-30 transform rotate-12"></div>
             <div class="absolute -bottom-5 -right-5 w-20 h-20 bg-blue-200 rounded-full opacity-30 transform -rotate-12"></div>
             
            <div id="questionContainer" class="text-center text-4xl font-bold mb-8 py-12 px-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg border-2 border-yellow-300 shadow-inner relative min-h-[100px] flex items-center justify-center">
                <!-- Floating shapes -->
                <div class="floating-shape shape1">+</div>
                <div class="floating-shape shape2">?</div>
                <div class="floating-shape shape3">=</div>
                <!-- Question text -->
                <span class="relative z-10"></span> 
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                <div class="w-full sm:w-1/2 relative group">
                    <span class="absolute -top-2 -left-2 text-3xl transform rotate-[-15deg]">✏️</span>
                    <input type="number" id="answer" class="w-full px-5 py-4 border-3 border-blue-400 rounded-full focus:ring-4 focus:ring-blue-200 focus:border-blue-500 text-xl font-semibold shadow-md text-center focus:scale-105 transition-transform" placeholder="Your Answer...">
                </div>
                <button id="submitAnswer" class="math-button primary w-full sm:w-auto group">
                    Check Answer!
                    <svg class="w-6 h-6 ml-2 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>

            <div id="feedback" class="text-center text-xl font-semibold mb-8 hidden p-6 rounded-lg min-h-[80px] flex items-center justify-center transition-all duration-300 ease-in-out">
                 <!-- Feedback content -->
            </div>

            <div class="text-center">
                <button id="nextQuestion" class="math-button secondary hidden group">
                    Next Question
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </button>
                 <button id="restartGame" class="math-button primary hidden group">
                     Play Again?
                     <svg class="w-5 h-5 ml-2 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0115.357-2m0 0H15"></path></svg>
                 </button>
            </div>
        </div>
        
        <!-- Fun Math Facts -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-100 rounded-xl shadow-lg p-6 border-4 border-yellow-300 border-dotted relative">
             <div class="absolute top-0 left-0 text-4xl -translate-x-3 -translate-y-3 transform rotate-[-10deg]">💡</div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
                Did You Know?
            </h3>
            <div class="p-4 bg-white rounded-lg shadow-inner">
                <p id="mathFact" class="text-gray-700 text-lg font-medium text-center">Loading fun fact...</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
<style>
    .font-comic-sans {
        font-family: 'Comic Neue', cursive;
    }

    .stat-bubble {
        padding: 8px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        border: 2px solid;
        box-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    .stat-bubble:hover {
        transform: scale(1.05);
    }

    /* Button styling */
    .math-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 150px;
        padding: 14px 24px;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 50px; /* Fully rounded */
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .math-button:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }

    .math-button:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    .math-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: 0 5px 10px rgba(0,0,0,0.15);
    }

    .math-button.primary {
        background: linear-gradient(to bottom right, #2dd4bf, #14b8a6); /* Teal gradient */
        color: white;
        border: 2px solid #5eead4; 
    }

    .math-button.primary:hover {
        background: linear-gradient(to bottom right, #14b8a6, #0d9488);
    }

    .math-button.secondary {
        background: linear-gradient(to bottom right, #f3f4f6, #e5e7eb);
        color: #374151;
        border: 2px solid #d1d5db;
    }

    .math-button.secondary:hover {
        background: linear-gradient(to bottom right, #e5e7eb, #d1d5db);
    }
    
    /* Input focus animation */
    @keyframes pulse-border {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }
    
    #answer:focus {
       /* animation: pulse-border 2s infinite; */ /* Optional: Re-enable if desired */
       border-color: #3b82f6; /* Simple border color change */
       box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
    
    /* Correct answer animation */
    @keyframes celebrate {
        0% { transform: scale(1); background-color: #fef3c7; }
        50% { transform: scale(1.05) rotate(1deg); background-color: #a7f3d0; }
        100% { transform: scale(1); background-color: #fef9c3; }
    }
    
    .celebrating {
        animation: celebrate 0.7s ease-in-out;
    }
    
    /* Floating shapes animation */
     .floating-shape {
        position: absolute;
        font-size: 2rem;
        font-weight: bold;
        color: rgba(0,0,0,0.1);
        user-select: none;
        animation: float 6s ease-in-out infinite;
    }
    .shape1 { top: 10%; left: 15%; animation-delay: 0s; color: #60a5fa; }
    .shape2 { top: 60%; right: 20%; animation-delay: 1.5s; color: #f87171; }
    .shape3 { bottom: 15%; left: 30%; animation-delay: 3s; color: #4ade80; }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    
    /* Confetti animation */
    .confetti {
        position: absolute;
        width: 8px;
        height: 15px;
        background-color: #10B981;
        border-radius: 2px;
        opacity: 0.8;
        animation: confetti-fall 3s ease-out forwards;
        z-index: 50; /* Ensure confetti is on top */
    }
    
    @keyframes confetti-fall {
        0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(calc(100vh - 100px)) rotate(720deg); opacity: 0; }
    }
    
    /* Feedback box styling */
    #feedback.correct {
        background-color: #dcfce7; /* Lighter green */
        color: #166534; /* Darker green */
        border: 2px solid #86efac;
        animation: feedback-pop 0.5s ease-out;
    }
    #feedback.incorrect {
        background-color: #fee2e2; /* Lighter red */
        color: #991b1b; /* Darker red */
        border: 2px solid #fca5a5;
         animation: feedback-shake 0.5s ease-out;
    }
    
    @keyframes feedback-pop {
        0% { transform: scale(0.8); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
     @keyframes feedback-shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }

     /* Game Over styling */
    #feedback.game-over {
        background: linear-gradient(to bottom, #e0f2fe, #dbeafe); /* Light blue gradient */
        color: #1e3a8a; /* Dark blue */
        border: 2px solid #93c5fd;
        padding: 25px;
        animation: feedback-pop 0.6s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() { // Use vanilla JS
        const mathGame = {
            // ... (properties: currentLevel, points, etc.) ...
            currentLevel: 1,
            points: 0,
            timeLeft: 60,
            timer: null,
            currentQuestion: null,
            correctAnswers: 0,
            questionsAsked: 0,
            mathFacts: {!! json_encode($game->content['facts'] ?? [
                "Zero is the only number that can't be represented in Roman numerals!",
                "A 'googol' is the number 1 followed by 100 zeros!",
                "The equals sign (=) was invented in 1557 by Robert Recorde."
            ]) !!},
            gameActive: true, // Flag to control game state

            // --- DOM Elements --- 
            elements: {
                 levelDisplay: document.getElementById('currentLevel'),
                 pointsDisplay: document.getElementById('points'),
                 timerDisplay: document.getElementById('timer'),
                 questionContainer: document.getElementById('questionContainer'),
                 questionText: document.querySelector('#questionContainer span'), // Target inner span
                 answerInput: document.getElementById('answer'),
                 submitBtn: document.getElementById('submitAnswer'),
                 feedbackBox: document.getElementById('feedback'),
                 nextBtn: document.getElementById('nextQuestion'),
                 restartBtn: document.getElementById('restartGame'),
                 mathFactDisplay: document.getElementById('mathFact')
            },

            // --- Initialization --- 
            init() {
                console.log("Math game initializing");
                this.showRandomMathFact();
                this.loadQuestion();
                this.setupEventListeners();
                this.startTimer();
                this.updateUI(); // Initial UI update
                console.log("Math game initialized");
            },

            // --- Core Game Logic --- 
            loadQuestion() {
                console.log("Loading question");
                const questions = {!! json_encode($game->content['questions'] ?? []) !!};
                
                if (questions.length === 0) {
                    this.currentQuestion = { question: 'No questions loaded!', answer: 0, explanation: 'Please add questions in the admin panel.' };
                    this.elements.questionText.textContent = this.currentQuestion.question;
                    this.elements.submitBtn.disabled = true;
                    return;
                }
                
                this.currentQuestion = questions[Math.floor(Math.random() * questions.length)];
                this.elements.questionText.textContent = this.currentQuestion.question;
                this.elements.answerInput.value = '';
                this.elements.answerInput.focus();
                this.elements.feedbackBox.classList.add('hidden');
                this.elements.nextBtn.classList.add('hidden');
                this.elements.restartBtn.classList.add('hidden'); // Ensure restart is hidden
                this.elements.submitBtn.disabled = false;
                this.elements.submitBtn.classList.remove('opacity-50');
                this.elements.answerInput.disabled = false; // Ensure input is enabled
                this.gameActive = true; // Make sure game is active
                
                this.questionsAsked++;
                console.log("Question loaded:", this.currentQuestion.question);
            },

            checkAnswer() {
                if (!this.gameActive) return; // Don't check if game is over

                const userAnswer = parseInt(this.elements.answerInput.value);
                console.log("Checking answer:", userAnswer);
                
                if (isNaN(userAnswer)) {
                    this.elements.feedbackBox.textContent = 'Please enter a number!';
                    this.elements.feedbackBox.className = 'text-center text-xl font-semibold mb-8 p-6 rounded-lg incorrect'; // Use class for styling
                    this.elements.feedbackBox.classList.remove('hidden');
                    return;
                }
                
                // Use loose equality (==) to compare user's number input with potentially string answer
                const isCorrect = (userAnswer == this.currentQuestion.answer); 
                this.elements.submitBtn.disabled = true; // Disable submit after checking
                this.elements.submitBtn.classList.add('opacity-50');
                this.elements.answerInput.disabled = true;

                if (isCorrect) {
                    this.points += 10;
                    this.correctAnswers++;
                    this.elements.feedbackBox.innerHTML = `<span class="text-2xl">🎉</span> Correct! Awesome job! +10 points`;
                    this.elements.feedbackBox.className = 'text-center text-xl font-semibold mb-8 p-6 rounded-lg correct';
                    this.elements.questionContainer.classList.add('celebrating');
                    this.createConfetti(); 
                    setTimeout(() => {
                        this.elements.questionContainer.classList.remove('celebrating');
                    }, 700);
                    
                    // Level up logic (example: every 3 correct)
                    if (this.correctAnswers > 0 && this.correctAnswers % 3 === 0) {
                        this.currentLevel++;
                         this.elements.feedbackBox.innerHTML += `<br><span class="text-2xl mt-2 block">🚀 Level Up to ${this.currentLevel}!</span>`;
                    }
                    console.log("Correct answer!");

                } else {
                    // Construct feedback message, only include explanation if it exists
                    let feedbackMessage = `<span class="text-xl">❌</span> Oops! The answer is ${this.currentQuestion.answer}.`;
                    if (this.currentQuestion.explanation && this.currentQuestion.explanation.trim() !== '') {
                        feedbackMessage += `<br><span class="text-base italic mt-1 block">(${this.currentQuestion.explanation})</span>`;
                    }
                    this.elements.feedbackBox.innerHTML = feedbackMessage;
                    this.elements.feedbackBox.className = 'text-center text-xl font-semibold mb-8 p-6 rounded-lg incorrect';
                    console.log("Incorrect answer");
                }

                this.elements.feedbackBox.classList.remove('hidden');
                this.elements.nextBtn.classList.remove('hidden');
                this.updateUI();
            },

            startTimer() {
                console.log("Starting timer");
                if (this.timer) clearInterval(this.timer);
                this.timeLeft = 60; 
                this.updateTimerDisplay(); // Initial display
                this.elements.timerDisplay.parentElement.classList.remove('animate-pulse', 'text-red-700'); // Reset pulse
                
                this.timer = setInterval(() => {
                     if (!this.gameActive) { // Stop timer if game ended
                         clearInterval(this.timer);
                         return;
                     }
                    this.timeLeft--;
                    this.updateTimerDisplay();

                    if (this.timeLeft <= 10 && this.timeLeft > 0) {
                        this.elements.timerDisplay.parentElement.classList.add('animate-pulse', 'text-red-700');
                    }
                    if (this.timeLeft <= 0) {
                        clearInterval(this.timer);
                        this.endGame('time'); // Pass reason
                    }
                }, 1000);
            },

            endGame(reason = 'manual') {
                console.log(`Game ended (reason: ${reason})`);
                this.gameActive = false; // Set game inactive
                clearInterval(this.timer); // Ensure timer stops
                
                const message = (reason === 'time') ? "⏰ Time's Up!" : "🏆 Game Over!";
                
                this.elements.feedbackBox.innerHTML = `
                    <div class="flex flex-col items-center gap-2">
                        <span class="text-3xl font-bold mb-2">${message}</span>
                        <span class="text-xl">Your score: <span class="font-bold">${this.points}</span> points</span>
                        <span class="text-lg">You reached Level ${this.currentLevel}!</span>
                         <div class="mt-3 text-lg flex gap-4">
                             <span>✔️ Correct: ${this.correctAnswers}</span>
                             <span>✖️ Incorrect: ${this.questionsAsked - this.correctAnswers}</span>
                         </div>
                    </div>`;
                this.elements.feedbackBox.className = 'text-center text-xl font-semibold mb-8 p-6 rounded-lg game-over'; // Special class for game over
                this.elements.feedbackBox.classList.remove('hidden');
                
                this.elements.submitBtn.disabled = true;
                this.elements.submitBtn.classList.add('opacity-50');
                this.elements.answerInput.disabled = true;
                this.elements.nextBtn.classList.add('hidden');
                this.elements.restartBtn.classList.remove('hidden'); // Show restart button
            },
            
            resetGame() {
                 console.log("Resetting game");
                this.currentLevel = 1;
                this.points = 0;
                this.correctAnswers = 0;
                this.questionsAsked = 0;
                this.gameActive = true;
                
                this.elements.restartBtn.classList.add('hidden');
                this.elements.answerInput.disabled = false;
                this.elements.submitBtn.disabled = false;
                this.elements.submitBtn.classList.remove('opacity-50');
                this.elements.timerDisplay.parentElement.classList.remove('animate-pulse', 'text-red-700');
                
                this.updateUI();
                this.showRandomMathFact();
                this.loadQuestion();
                this.startTimer();
            },

            // --- UI Updates & Effects --- 
            updateUI() {
                this.elements.levelDisplay.textContent = this.currentLevel;
                this.elements.pointsDisplay.textContent = this.points;
                console.log("UI updated - Level:", this.currentLevel, "Points:", this.points);
            },
            
             updateTimerDisplay() {
                 this.elements.timerDisplay.textContent = this.timeLeft;
             },
            
            showRandomMathFact() {
                if (this.mathFacts.length > 0) {
                    const randomFact = this.mathFacts[Math.floor(Math.random() * this.mathFacts.length)];
                    this.elements.mathFactDisplay.textContent = randomFact;
                } else {
                    this.elements.mathFactDisplay.textContent = "Add some fun facts in the admin panel!";
                }
            },

            createConfetti() {
                const confettiContainer = document.querySelector('.max-w-4xl'); // Relative container
                if (!confettiContainer) return;
                
                const colors = ['#2dd4bf', '#3b82f6', '#ec4899', '#f59e0b', '#a855f7', '#84cc16'];
                const shapes = ['■', '●', '▲', '◆', '★']; // Square, Circle, Triangle, Diamond, Star
                
                for (let i = 0; i < 40; i++) { // More confetti!
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.textContent = shapes[Math.floor(Math.random() * shapes.length)];
                    confetti.style.left = `${Math.random() * 100}%`;
                    confetti.style.color = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.fontSize = `${Math.random() * 15 + 10}px`; // Vary size
                    confetti.style.animationDuration = `${Math.random() * 2 + 2.5}s`; // Vary speed
                     confetti.style.transform = `rotate(${Math.random() * 360}deg)`; // Initial rotation
                    
                    // Custom property for horizontal drift
                    confetti.style.setProperty('--drift', `${Math.random() * 100 - 50}px`); 
                    
                    confettiContainer.appendChild(confetti);
                    
                    // Remove confetti after animation ends
                    setTimeout(() => {
                        confetti.remove();
                    }, 4500); // Slightly longer than max animation duration
                }
            },

            // --- Event Setup --- 
            setupEventListeners() {
                console.log("Setting up event listeners");
                this.elements.submitBtn.addEventListener('click', () => this.checkAnswer());
                this.elements.nextBtn.addEventListener('click', () => {
                    this.showRandomMathFact();
                    this.loadQuestion();
                });
                this.elements.restartBtn.addEventListener('click', () => this.resetGame());
                this.elements.answerInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && this.gameActive) {
                        this.checkAnswer();
                    }
                });
            }
        };

        // Initialize the game
        mathGame.init();
    });
</script>
@endpush
@endsection 