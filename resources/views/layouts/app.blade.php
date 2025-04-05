<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kids Reading') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Comic Neue', cursive;
            background-color: #E3F2FD;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <nav class="bg-blue-500 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold">Kids Reading</a>
            <div class="space-x-4">
                <a href="{{ route('home') }}" class="hover:text-blue-200">Home</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-200">Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-200">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-blue-200">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-8 px-4">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-blue-500 text-white p-4 mt-auto">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} Kids Reading. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 