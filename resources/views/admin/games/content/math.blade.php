@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Manage Math Adventure: {{ $game->title }}</h1>
        <a href="{{ route('admin.games.edit', $game) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Back to Game
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Game Settings</h2>
        <form action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="update_type" value="settings">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Limit (seconds)</label>
                    <input type="number" name="content[settings][time_limit]" value="{{ $game->content['settings']['time_limit'] ?? 60 }}"
                           class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           min="10" max="300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Points per Correct Answer</label>
                    <input type="number" name="content[settings][points_per_correct]" value="{{ $game->content['settings']['points_per_correct'] ?? 10 }}"
                           class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           min="1" max="100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Points to Advance Level</label>
                    <input type="number" name="content[settings][points_needed_to_advance]" value="{{ $game->content['settings']['points_needed_to_advance'] ?? 50 }}"
                           class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           min="10" max="1000">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Settings
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Manage Questions</h2>
            <button type="button" onclick="addNewQuestion()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Question
            </button>
        </div>

        <form id="questionsForm" action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="update_type" value="questions">

            <div id="questionsContainer" class="space-y-6">
                @foreach($game->content['questions'] ?? [] as $index => $question)
                <div class="question-item border rounded-lg p-4 bg-gray-50" data-index="{{ $index }}">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-md font-medium text-gray-900">Question {{ $index + 1 }}</h3>
                        <button type="button" onclick="removeQuestion(this)" class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                            <textarea name="content[questions][{{ $index }}][question]" rows="2" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter the question">{{ is_scalar($question['question'] ?? '') ? ($question['question'] ?? '') : json_encode($question['question'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
                            <input type="number" name="content[questions][{{ $index }}][answer]" value="{{ is_scalar($question['answer'] ?? '') ? ($question['answer'] ?? '') : '' }}" step="0.01"
                                   class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="Enter the correct answer">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Explanation (Optional)</label>
                            <textarea name="content[questions][{{ $index }}][explanation]" rows="2" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter an explanation for the answer">{{ is_scalar($question['explanation'] ?? '') ? ($question['explanation'] ?? '') : json_encode($question['explanation'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Questions
                </button>
            </div>
        </form>
    </div>

    <!-- Manage Fun Facts Section -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Manage Fun Facts</h2>
            <button type="button" id="addFactBtn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                 <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                 </svg>
                Add Fun Fact
            </button>
        </div>

        <form id="factsForm" action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="update_type" value="facts"> <!-- Identifier for controller -->

            <div id="factsContainer" class="space-y-4">
                @forelse($game->content['facts'] ?? [] as $index => $fact)
                <div class="fact-item flex items-center space-x-2 bg-gray-50 p-3 rounded-md" data-index="{{ $index }}">
                    <span class="fact-number text-gray-500 font-medium mr-2">{{ $index + 1 }}.</span>
                    <textarea name="content[facts][{{ $index }}]" rows="2" 
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md flex-grow"
                              placeholder="Enter a fun fact">{{ $fact }}</textarea>
                    <button type="button" class="remove-fact-btn text-red-600 hover:text-red-800 flex-shrink-0">
                        <svg class="h-5 w-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                @empty
                <p id="noFactsMessage" class="text-center text-gray-500 py-4">No fun facts added yet.</p>
                @endforelse
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Fun Facts
                </button>
            </div>
        </form>
    </div>
    <!-- End Manage Fun Facts Section -->

</div>

<!-- Template for new questions (hidden) -->
<template id="questionTemplate">
    <div class="question-item border rounded-lg p-4 bg-gray-100 opacity-0 transform scale-95 transition-all duration-300 ease-in-out" data-index="__INDEX__">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-md font-medium text-gray-900">Question <span class="question-number">__NUMBER__</span></h3>
            <button type="button" class="remove-question-btn text-red-600 hover:text-red-800 transition-colors">
                <svg class="h-5 w-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="question-text-__INDEX__" class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                <textarea id="question-text-__INDEX__" name="content[questions][__INDEX__][question]" rows="2" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter the question"></textarea>
            </div>
            <div>
                <label for="question-answer-__INDEX__" class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                <input id="question-answer-__INDEX__" type="number" name="content[questions][__INDEX__][answer]" step="0.01"
                       class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                       placeholder="Enter the correct answer">
            </div>
            <div class="md:col-span-2">
                <label for="question-explanation-__INDEX__" class="block text-sm font-medium text-gray-700 mb-1">Explanation (Optional)</label>
                <textarea id="question-explanation-__INDEX__" name="content[questions][__INDEX__][explanation]" rows="2" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter an explanation for the answer"></textarea>
            </div>
        </div>
    </div>
</template>

<!-- Template for new facts (hidden) -->
<template id="factTemplate">
     <div class="fact-item flex items-center space-x-2 bg-gray-100 p-3 rounded-md opacity-0 transform scale-95 transition-all duration-300 ease-in-out" data-index="__INDEX__">
         <span class="fact-number text-gray-500 font-medium mr-2">__NUMBER__.</span>
         <textarea name="content[facts][__INDEX__]" rows="2" 
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md flex-grow"
                   placeholder="Enter a fun fact"></textarea>
         <button type="button" class="remove-fact-btn text-red-600 hover:text-red-800 flex-shrink-0">
             <svg class="h-5 w-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
             </svg>
         </button>
     </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Questions Logic --- 
    const questionsContainer = document.getElementById('questionsContainer');
    const addQuestionBtn = document.querySelector('button[onclick="addNewQuestion()"]');
    const questionTemplate = document.getElementById('questionTemplate');
    const noQuestionsMessage = document.querySelector('#questionsContainer > p');

    if (!addQuestionBtn) console.error('[MathAdmin] Add Question button not found!');
    if (!questionsContainer) console.error('[MathAdmin] Questions container not found!');
    if (!questionTemplate) console.error('[MathAdmin] Question template not found!');

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            question.querySelector('.question-number').textContent = index + 1;
            question.dataset.index = index;
            const qInput = question.querySelector('textarea[name*="[question]"]');
            const aInput = question.querySelector('input[name*="[answer]"]');
            const eInput = question.querySelector('textarea[name*="[explanation]"]');
            if(qInput) qInput.name = `content[questions][${index}][question]`;
            if(aInput) aInput.name = `content[questions][${index}][answer]`;
            if(eInput) eInput.name = `content[questions][${index}][explanation]`;
        });
        if (noQuestionsMessage) {
            noQuestionsMessage.style.display = questions.length === 0 ? 'block' : 'none';
        }
    }

    function addNewQuestion() {
        if (!questionTemplate || !questionsContainer) return;
        const index = questionsContainer.querySelectorAll('.question-item').length;
        const templateContent = questionTemplate.content.cloneNode(true);
        const newQuestionElement = templateContent.querySelector('.question-item');
        if (!newQuestionElement) return;
        newQuestionElement.dataset.index = index;
        newQuestionElement.querySelector('.question-number').textContent = index + 1;
        const qInput = newQuestionElement.querySelector('textarea[name*="[question]"]');
        const aInput = newQuestionElement.querySelector('input[name*="[answer]"]');
        const eInput = newQuestionElement.querySelector('textarea[name*="[explanation]"]');
        if(qInput) qInput.name = `content[questions][${index}][question]`;
        if(aInput) aInput.name = `content[questions][${index}][answer]`;
        if(eInput) eInput.name = `content[questions][${index}][explanation]`;
        questionsContainer.appendChild(templateContent);
        requestAnimationFrame(() => {
             requestAnimationFrame(() => {
                  if(newQuestionElement) {
                     newQuestionElement.classList.remove('opacity-0', 'scale-95');
                  }
             });
        });
        const removeBtn = newQuestionElement.querySelector('.remove-question-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', removeQuestion);
        }
        updateQuestionNumbers();
        const firstInput = newQuestionElement.querySelector('textarea, input');
         if(firstInput) {
            firstInput.focus();
        }
    }

    function removeQuestion(event) {
        const questionItem = event.target.closest('.question-item');
        if (questionItem) {
             questionItem.classList.add('opacity-0', 'scale-90');
             questionItem.style.height = questionItem.offsetHeight + 'px';
            setTimeout(() => {
                questionItem.remove();
                updateQuestionNumbers();
            }, 300);
        }
    }
    
    // --- Fun Facts Logic --- 
    const factsContainer = document.getElementById('factsContainer');
    const addFactBtn = document.getElementById('addFactBtn');
    const factTemplate = document.getElementById('factTemplate');
    const noFactsMessage = document.getElementById('noFactsMessage');

    if (!addFactBtn) console.error('[MathAdmin] Add Fact button not found!');
    if (!factsContainer) console.error('[MathAdmin] Facts container not found!');
    if (!factTemplate) console.error('[MathAdmin] Fact template not found!');

    function updateFactNumbers() {
        const facts = factsContainer.querySelectorAll('.fact-item');
        facts.forEach((fact, index) => {
            fact.querySelector('.fact-number').textContent = index + 1 + '.';
            fact.dataset.index = index;
            const textarea = fact.querySelector('textarea');
            if (textarea) {
                 textarea.name = `content[facts][${index}]`;
            }
        });
         if (noFactsMessage) {
            noFactsMessage.style.display = facts.length === 0 ? 'block' : 'none';
        }
    }

    function addNewFact() {
        if (!factTemplate || !factsContainer) return;

        const index = factsContainer.querySelectorAll('.fact-item').length;
        const templateContent = factTemplate.content.cloneNode(true);
        const newFactElement = templateContent.querySelector('.fact-item');

        if (!newFactElement) return;

        newFactElement.dataset.index = index;
        newFactElement.querySelector('.fact-number').textContent = index + 1 + '.';
        const textarea = newFactElement.querySelector('textarea');
        if (textarea) {
            textarea.name = `content[facts][${index}]`;
        }

        factsContainer.appendChild(templateContent);

        requestAnimationFrame(() => {
             requestAnimationFrame(() => {
                 if(newFactElement) {
                     newFactElement.classList.remove('opacity-0', 'scale-95');
                 }
             });
        });

        const removeBtn = newFactElement.querySelector('.remove-fact-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', removeFact);
        }

        updateFactNumbers();
        
         if(textarea) {
             textarea.focus();
         }
    }

    function removeFact(event) {
        const factItem = event.target.closest('.fact-item');
        if (factItem) {
             factItem.classList.add('opacity-0', 'scale-90');
             factItem.style.height = factItem.offsetHeight + 'px';
            setTimeout(() => {
                factItem.remove();
                updateFactNumbers();
            }, 300);
        }
    }

    // --- Initial Setup & Event Listeners ---
    if (addQuestionBtn) {
        addQuestionBtn.addEventListener('click', addNewQuestion);
    }
    if (addFactBtn) {
        addFactBtn.addEventListener('click', addNewFact);
    }

    questionsContainer.querySelectorAll('.remove-question-btn').forEach(button => {
        button.addEventListener('click', removeQuestion);
    });
    factsContainer.querySelectorAll('.remove-fact-btn').forEach(button => {
        button.addEventListener('click', removeFact);
    });

    updateQuestionNumbers();
    updateFactNumbers();
});
</script>
@endpush
@endsection 