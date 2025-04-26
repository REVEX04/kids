<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnimeauxController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Public routes
Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/stories/{story:slug}', [StoryController::class, 'show'])->name('stories.show');
Route::post('/stories/{story}/rate', [StoryController::class, 'rate'])->name('stories.rate');

// Games routes
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

// Routes publiques pour les animaux
Route::get('/animeaux', [AnimeauxController::class, 'index'])->name('animeaux.index');
Route::get('/animeaux/type/{type}', [AnimeauxController::class, 'type'])->name('animeaux.type');
Route::get('/animeaux/{animal}', [AnimeauxController::class, 'show'])->name('animeaux.show');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Stories
    Route::get('/stories', [StoryController::class, 'adminIndex'])->name('stories.index');
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    Route::get('/stories/{story}/remove-media/{type}', [StoryController::class, 'removeMedia'])->name('stories.remove-media');

    // Games
    Route::get('/games', [GameController::class, 'adminIndex'])->name('games.index');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
    
    // Game content management
    Route::get('/games/{game}/content', [GameController::class, 'manageContent'])->name('games.content');
    Route::put('/games/{game}/content', [GameController::class, 'updateContent'])->name('games.content.update');
    Route::post('/games/{game}/upload', [GameController::class, 'uploadFile'])->name('games.upload');

    // Routes administratives pour les animaux
    Route::resource('animeaux', AnimeauxController::class);
});
