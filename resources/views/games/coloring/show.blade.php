@extends('layouts.game')

@section('content')
<div class="bg-gradient-to-b from-indigo-50 to-purple-100 min-h-screen py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Game Header -->
        <div class="mb-6 bg-white rounded-xl shadow-lg p-4 flex flex-col sm:flex-row justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-purple-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $game->title }}</h1>
            </div>
        </div>

        <!-- Coloring Container -->
        <div class="grid grid-cols-1 md:grid-cols-3 md:gap-6">
            <!-- Canvas Area -->
            <div class="col-span-2 bg-white rounded-xl shadow-lg p-4 mb-6 md:mb-0">
                <div class="canvas-container mb-4">
                    <canvas id="drawingCanvas" class="w-full rounded shadow-sm"></canvas>
                </div>
                
                <!-- Custom Background Upload -->
                <div class="flex justify-between mb-4">
                    <div>
                        <label class="flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md cursor-pointer hover:bg-indigo-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Change Background
                            <input type="file" id="customBackground" class="hidden" accept="image/*">
                        </label>
                        <div class="mt-2 text-xs text-gray-500">
                            <p>Note: Browser security prevents direct access to files on your computer.</p>
                            <p>Please use this button to select Desktop/test.jpg</p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button id="clearDrawing" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Clear
                        </button>
                        
                        <button id="saveDrawing" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Save
                        </button>
                    </div>
                </div>
                
                <!-- Tools Panel -->
                <div class="lg:w-1/4 bg-gray-50 p-4 rounded-lg shadow-inner">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        Coloring Tools
                    </h3>

                    <!-- Brush Sizes -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brush Size</label>
                        <div class="flex items-center justify-between">
                            <button id="smallBrush" class="brush-size-btn active" data-size="5">
                                <div class="w-3 h-3 rounded-full bg-current"></div>
                            </button>
                            <button id="mediumBrush" class="brush-size-btn" data-size="10">
                                <div class="w-5 h-5 rounded-full bg-current"></div>
                            </button>
                            <button id="largeBrush" class="brush-size-btn" data-size="15">
                                <div class="w-7 h-7 rounded-full bg-current"></div>
                            </button>
                            <button id="xlargeBrush" class="brush-size-btn" data-size="20">
                                <div class="w-9 h-9 rounded-full bg-current"></div>
                            </button>
                        </div>
                    </div>

                    <!-- Color Palette -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Colors</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button class="color-btn active" style="background-color: #000000;" data-color="#000000"></button>
                            <button class="color-btn" style="background-color: #FF0000;" data-color="#FF0000"></button>
                            <button class="color-btn" style="background-color: #00FF00;" data-color="#00FF00"></button>
                            <button class="color-btn" style="background-color: #0000FF;" data-color="#0000FF"></button>
                            <button class="color-btn" style="background-color: #FFFF00;" data-color="#FFFF00"></button>
                            <button class="color-btn" style="background-color: #FF00FF;" data-color="#FF00FF"></button>
                            <button class="color-btn" style="background-color: #00FFFF;" data-color="#00FFFF"></button>
                            <button class="color-btn" style="background-color: #FFA500;" data-color="#FFA500"></button>
                            <button class="color-btn" style="background-color: #800080;" data-color="#800080"></button>
                            <button class="color-btn" style="background-color: #008000;" data-color="#008000"></button>
                            <button class="color-btn" style="background-color: #A52A2A;" data-color="#A52A2A"></button>
                            <button class="color-btn" style="background-color: #FFFFFF;" data-color="#FFFFFF" style="border: 1px solid #ddd;"></button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button id="clearDrawing" class="color-button secondary w-full">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Clear Drawing
                        </button>
                        <button id="saveDrawing" class="color-button primary w-full">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Save Drawing
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tips Box -->
            <div class="col-span-1 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path>
                    </svg>
                    Coloring Tips
                </h3>
                <ul class="text-gray-600 text-sm space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Start with lighter colors first, then add darker details
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Use smaller brush sizes for details and larger ones for filling
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Don't forget to save your drawing when you're finished!
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Canvas styling */
    .canvas-container {
        aspect-ratio: 4/3;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #drawingCanvas {
        max-width: 100%;
        background-color: white;
    }
    
    /* Brush size buttons */
    .brush-size-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: white;
        color: #6B7280;
        border: 2px solid #E5E7EB;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .brush-size-btn:hover, .brush-size-btn.active {
        color: #7C3AED;
        border-color: #7C3AED;
        transform: scale(1.1);
    }
    
    /* Color buttons */
    .color-btn {
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    
    .color-btn:hover, .color-btn.active {
        transform: scale(1.1);
        box-shadow: 0 0 0 2px white, 0 0 0 4px #7C3AED;
    }
    
    /* Button styling */
    .color-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        padding: 10px 16px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .color-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .color-button:active {
        transform: translateY(1px);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .color-button.primary {
        background-color: #8B5CF6;
        color: white;
    }

    .color-button.primary:hover {
        background-color: #7C3AED;
    }

    .color-button.secondary {
        background-color: #f3f4f6;
        color: #374151;
    }

    .color-button.secondary:hover {
        background-color: #e5e7eb;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        console.log("Coloring game initializing");
        
        // Get canvas element
        const canvas = document.getElementById('drawingCanvas');
        const ctx = canvas.getContext('2d');
        const container = canvas.parentElement;
        
        // Initialize variables
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;
        let currentColor = '#000000';
        let currentSize = 5;
        
        // Load initial image if provided in game content
        const content = {!! json_encode($game->content ?? []) !!};
        console.log("Game content:", content);
        
        // Set canvas size based on container
        function resizeCanvas() {
            const rect = container.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.width * 0.75; // 4:3 aspect ratio
            console.log("Canvas resized to:", canvas.width, "x", canvas.height);
            
            // Load the specific background image from Desktop/test.jpg
            loadBackgroundImage('file:///C:/Users/Administrateur/Desktop/test.jpg');
        }
        
        // Initial resize
        resizeCanvas();
        
        // Handle window resize
        window.addEventListener('resize', resizeCanvas);
        
        // Load background image
        function loadBackgroundImage(src) {
            const img = new Image();
            img.crossOrigin = "Anonymous"; // Handle CORS issues
            
            img.onload = function() {
                console.log("Background image loaded");
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            
            img.onerror = function(err) {
                console.error("Error loading background image:", err);
                // Show error message on canvas
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'red';
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Error loading image. Try again later.', canvas.width/2, canvas.height/2);
                alert('Could not load image from ' + src + '. Browser security may prevent loading local files directly. Please use the "Change Background" button instead.');
            };
            
            try {
                img.src = src;
                console.log("Loading background image:", src);
            } catch (err) {
                console.error("Error setting image source:", err);
            }
        }
        
        // Custom background image upload
        $('#customBackground').on('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                loadBackgroundImage(e.target.result);
            };
            reader.readAsDataURL(file);
        });
        
        // Drawing functions
        function startDrawing(e) {
            isDrawing = true;
            [lastX, lastY] = getMousePos(canvas, e);
            console.log("Drawing started at:", lastX, lastY);
        }
        
        function draw(e) {
            if (!isDrawing) return;
            
            const [currentX, currentY] = getMousePos(canvas, e);
            
            ctx.strokeStyle = currentColor;
            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';
            ctx.lineWidth = currentSize;
            
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(currentX, currentY);
            ctx.stroke();
            
            [lastX, lastY] = [currentX, currentY];
        }
        
        function stopDrawing() {
            isDrawing = false;
        }
        
        // Helper to get mouse position
        function getMousePos(canvas, e) {
            const rect = canvas.getBoundingClientRect();
            return [
                (e.clientX - rect.left) / (rect.right - rect.left) * canvas.width,
                (e.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height
            ];
        }
        
        // Event listeners for drawing
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
        
        // Touch support for mobile
        canvas.addEventListener('touchstart', function(e) {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousedown', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        });
        
        canvas.addEventListener('touchmove', function(e) {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        });
        
        canvas.addEventListener('touchend', function(e) {
            e.preventDefault();
            const mouseEvent = new MouseEvent('mouseup');
            canvas.dispatchEvent(mouseEvent);
        });
        
        // Clear drawing button
        $('#clearDrawing').on('click', function() {
            console.log("Clearing drawing");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // If there was a background image, redraw it
            if (content.backgroundImage) {
                loadBackgroundImage(content.backgroundImage);
            } else {
                // Default white background
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
        });
        
        // Save drawing button
        $('#saveDrawing').on('click', function() {
            console.log("Saving drawing");
            try {
                const dataURL = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'my-drawing.png';
                link.href = dataURL;
                link.click();
            } catch (err) {
                console.error("Error saving drawing:", err);
                alert('Unable to save drawing. Try again later.');
            }
        });
        
        // Brush size buttons
        $('.brush-size-btn').on('click', function() {
            $('.brush-size-btn').removeClass('active');
            $(this).addClass('active');
            currentSize = parseInt($(this).data('size'));
            console.log("Brush size changed to:", currentSize);
        });
        
        // Color buttons
        $('.color-btn').on('click', function() {
            $('.color-btn').removeClass('active');
            $(this).addClass('active');
            currentColor = $(this).data('color');
            console.log("Color changed to:", currentColor);
        });
        
        console.log("Coloring game initialized");
    });
</script>
@endpush
@endsection 