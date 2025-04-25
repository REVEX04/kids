<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{
    // Public methods
    public function index()
    {
        $games = Game::where('is_published', true)
            ->orderBy('title')
            ->get()
            ->groupBy('type');
            
        return view('games.index', compact('games'));
    }

    public function show(Game $game)
    {
        if (!$game->is_published) {
            abort(404);
        }

        $game->increment('plays');
        
        return view("games.{$game->type}.show", compact('game'));
    }

    // Admin methods
    public function adminIndex()
    {
        $games = Game::latest()->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $gameTypes = Game::getTypes();
        return view('admin.games.create', compact('gameTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:' . implode(',', array_keys(Game::getTypes())),
            'is_published' => 'boolean',
        ]);

        $validated['content'] = Game::getDefaultContent($validated['type']);
        $validated['slug'] = Str::slug($validated['title']);

        Game::create($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game created successfully.');
    }

    public function edit(Game $game)
    {
        $gameTypes = Game::getTypes();
        return view('admin.games.edit', compact('game', 'gameTypes'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_published' => 'boolean',
        ]);

        if ($game->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $game->update($validated);

        return redirect()->route('admin.games.edit', $game)
            ->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')
            ->with('success', 'Game deleted successfully.');
    }

    // Game content management
    public function manageContent(Game $game)
    {
        return view("admin.games.content.{$game->type}", compact('game'));
    }

    public function updateContent(Request $request, Game $game)
    {
        // Initialize content if it doesn't exist
        $currentContent = $game->content; // Get the decoded array via accessor
        if (!is_array($currentContent)) { // Ensure it's an array
             $currentContent = Game::getDefaultContent($game->type);
        }

        // Handle image upload (kept separate as it uses FormData)
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $path = $request->file('image')->store("games/{$game->type}", 'public');
            
            // Modify the temporary array
            if (!isset($currentContent['images'])) {
                $currentContent['images'] = [];
            }
            $currentContent['images'][] = [
                'title' => pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME),
                'path' => $path
            ];
            
            // Assign the modified array back to trigger the mutator
            $game->content = $currentContent; 
            $game->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully'
            ]);
        }

        // Handle image deletion (kept separate as it might come via AJAX)
        if ($request->input('action') === 'delete_image' && $request->has('delete_image')) {
            $imagePath = $request->input('delete_image');
            Storage::disk('public')->delete($imagePath);
            
            // Modify the temporary array
            $currentContent['images'] = collect($currentContent['images'] ?? [])->filter(function ($image) use ($imagePath) {
                return $image['path'] !== $imagePath;
            })->values()->all();
            
            // Assign the modified array back to trigger the mutator
            $game->content = $currentContent;
            $game->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        // Handle regular form submissions (Settings or Cards/Questions)
        if ($request->has('update_type')) {
            
            $updateType = $request->input('update_type');
            $validated = $request->validate(['content' => 'required|array']); // Basic validation
            $processedContent = $validated['content']; // Get validated content

            if ($updateType === 'settings') {
                // Validate specific settings fields
                $settingsRules = [];
                if ($game->type === 'flashcard') {
                    $settingsRules = [
                        'content.settings.showProgress' => 'required|boolean',
                        'content.settings.shuffleCards' => 'required|boolean',
                    ];
                } elseif ($game->type === 'math') {
                     $settingsRules = [
                         'content.settings.time_limit' => 'required|integer|min:10|max:300',
                         'content.settings.points_per_correct' => 'required|integer|min:1|max:100',
                         'content.settings.points_needed_to_advance' => 'required|integer|min:10|max:1000',
                     ];
                } elseif ($game->type === 'coloring') {
                     $settingsRules = [
                         'content.settings.brush_sizes' => 'sometimes|array',
                         'content.settings.brush_sizes.*' => 'required|integer|min:1|max:50',
                         'content.settings.default_colors' => 'sometimes|array',
                         'content.settings.default_colors.*' => ['required', 'regex:/^#[a-fA-F0-9]{6}$/'],
                     ];
                }
                
                $validatedSettings = $request->validate($settingsRules);

                // Merge settings into the temporary array
                $currentContent['settings'] = array_merge(
                    $currentContent['settings'] ?? [],
                    $validatedSettings['content']['settings'] ?? []
                );

            } elseif ($updateType === 'cards' && $game->type === 'flashcard') {
                // Validate cards
                $validatedCards = $request->validate([
                    'content.cards' => 'sometimes|array',
                    'content.cards.*.front' => 'nullable|string',
                    'content.cards.*.back' => 'nullable|string',
                ]);
                
                $cards = $validatedCards['content']['cards'] ?? [];
                // Filter out empty cards and re-index
                $currentContent['cards'] = array_values(array_filter($cards, function($card) {
                    return !empty($card['front']) || !empty($card['back']);
                }));

            } elseif ($updateType === 'questions' && $game->type === 'math') {
                // Validate questions for Math game
                $validatedQuestions = $request->validate([
                    'content.questions' => 'sometimes|array',
                    'content.questions.*.question' => 'required_with:content.questions|string',
                    'content.questions.*.answer' => 'required_with:content.questions|numeric',
                    'content.questions.*.explanation' => 'nullable|string',
                ]);
                $questions = $validatedQuestions['content']['questions'] ?? [];
                $currentContent['questions'] = array_values(array_filter($questions, function($q) {
                     return !empty($q['question']) && isset($q['answer']);
                }));
            
             } elseif ($updateType === 'images' && $game->type === 'coloring') {
                // Validate images array (titles)
                 $validatedImages = $request->validate([
                    'content.images' => 'sometimes|array',
                    'content.images.*.title' => 'required|string',
                    'content.images.*.path' => 'required|string', // Ensure path is submitted
                 ]);
                 $currentContent['images'] = $validatedImages['content']['images'] ?? [];

            } elseif ($updateType === 'facts' && $game->type === 'math') {
                // Validate facts
                $validatedFacts = $request->validate([
                    'content.facts' => 'sometimes|array',
                    'content.facts.*' => 'nullable|string', // Allow empty strings initially
                ]);
                
                $facts = $validatedFacts['content']['facts'] ?? [];
                
                // Filter out genuinely empty/null facts and re-index
                $currentContent['facts'] = array_values(array_filter($facts, function($fact) {
                    return !is_null($fact) && trim($fact) !== '';
                }));

            } else {
                 // Unknown update type or type mismatch
                 return redirect()->route('admin.games.content', $game)
                    ->with('error', 'Invalid update request.');
            }

            // Assign the entire modified array back to the model property
            $game->content = $currentContent;
            $game->save();
            
            return redirect()->route('admin.games.content', $game)
                ->with('success', 'Game content updated successfully.');
        }

        // If no specific update type, image upload, or deletion was processed
        return redirect()->route('admin.games.content', $game)
            ->with('error', 'No valid content update action provided.');
    }

    // Handle file uploads for games
    public function uploadFile(Request $request, Game $game)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|string|in:coloring,flashcard',
        ]);

        $path = $request->file('file')->store("games/{$request->type}", 'public');

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path)
        ]);
    }
} 