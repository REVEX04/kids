<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kids Reading') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    },
                    keyframes: {
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Comic Neue', cursive;
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url('{{ asset('images/Background/nature-landscape-illustration-with-a-cute-and-colorful-design-suitable-for-kids-background-free-vector.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .dark body {
            background-color: #1a1a1a;
            color: #ffffff;
            background-image: url('{{ asset('images/Background/nature-landscape-illustration-with-a-cute-and-colorful-design-suitable-for-kids-background-free-vector.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .nav-item {
            transition: transform 0.2s ease;
        }
        
        .nav-item:hover {
            transform: scale(1.1);
        }
        
        .page-transition {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        main {
            flex: 1 0 auto;
            min-height: calc(100vh - 144px);
            padding-bottom: 2rem;
        }
        
        footer {
            flex-shrink: 0;
            width: 100%;
            background: linear-gradient(to right, #3b82f6, #2563eb);
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .dark footer {
            background: linear-gradient(to right, #1e40af, #1e3a8a);
        }
        
        /* Tutorial tooltip styles */
        .tutorial-tip {
            position: relative;
            display: inline-block;
        }
        
        .tutorial-tip .tooltip-text {
            visibility: hidden;
            background-color: #4299e1;
            color: white;
            text-align: center;
            padding: 8px;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tutorial-tip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-blue-50 dark:bg-gray-900 transition-colors duration-300">
    <nav class="bg-blue-500 dark:bg-blue-800 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center space-x-2 nav-item">
                <span class="animate-bounce-slow">📚</span>
                <span>Kids Reading</span>
            </a>
            
            <div class="flex items-center space-x-6">
                <!-- Dark mode toggle -->
                <button 
                    @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="p-2 rounded-full hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-200"
                >
                    <span x-show="!darkMode" class="text-xl">🌙</span>
                    <span x-show="darkMode" class="text-xl">☀️</span>
                </button>
                
                <!-- Navigation items -->
                <div class="flex space-x-4">
                    <a href="{{ route('home') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                        <span class="text-xl">🏠</span>
                        <span>Home</span>
                        <span class="tooltip-text">Go to homepage</span>
                    </a>
                    
                    <!-- Add Games Link Here -->
                     <a href="{{ route('games.index') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                         <span class="text-xl">🎮</span>
                         <span>Games</span>
                         <span class="tooltip-text">Play fun games!</span>
                     </a>
                     <!-- End Games Link -->

                    <!-- Add Animaux Link -->
                     <a href="{{ route('animeaux.index') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                         <span class="text-xl">🦁</span>
                         <span>Animaux</span>
                         <span class="tooltip-text">Découvre le monde des animaux!</span>
                     </a>
                     <!-- End Animaux Link -->
                    
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                                <span class="text-xl">⚙️</span>
                                <span>Admin</span>
                                <span class="tooltip-text">Manage content</span>
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="nav-item flex items-center space-x-1 tutorial-tip">
                                <span class="text-xl">👋</span>
                                <span>Logout</span>
                                <span class="tooltip-text">See you next time!</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                            <span class="text-xl">🔑</span>
                            <span>Login</span>
                            <span class="tooltip-text">Sign in to your account</span>
                        </a>
                        <a href="{{ route('register') }}" class="nav-item flex items-center space-x-1 tutorial-tip">
                            <span class="text-xl">✨</span>
                            <span>Register</span>
                            <span class="tooltip-text">Create a new account</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-8 px-4 page-transition">
        @if (session('success'))
            <div class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded animate-bounce-slow">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded animate-wiggle">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-white py-6">
        <div class="container mx-auto text-center">
            <div class="flex flex-col items-center justify-center space-y-4">
                <p class="text-sm opacity-90">&copy; {{ now()->year }} Kids Reading. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Tutorial System -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if it's the user's first visit
            if (!localStorage.getItem('tutorialShown')) {
                showTutorial();
                localStorage.setItem('tutorialShown', 'true');
            }
        });

        function showTutorial() {
            const tutorial = document.createElement('div');
            tutorial.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            tutorial.innerHTML = `
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md">
                    <h2 class="text-2xl font-bold mb-4">Welcome to Kids Reading! 🎉</h2>
                    <p class="mb-4">Here's a quick guide to help you get started:</p>
                    <ul class="list-disc pl-5 mb-4 space-y-2">
                        <li>Hover over any icon to see what it does</li>
                        <li>Try the dark mode toggle for comfortable reading</li>
                        <li>Click on any game card to start playing</li>
                        <li>Have fun learning! 🌟</li>
                    </ul>
                    <button onclick="this.parentElement.parentElement.remove()" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                        Got it!
                    </button>
                </div>
            `;
            document.body.appendChild(tutorial);
        }
    </script>
</body>
</html> 