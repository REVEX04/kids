<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display a listing of stories in admin panel.
     */
    public function adminIndex()
    {
        $stories = Story::with('category')->latest()->paginate(10);
        return view('admin.stories.index', compact('stories'));
    }

    /**
     * Display the specified story.
     */
    public function show(Story $story)
    {
        if (!$story->is_published) {
            abort(404);
        }

        // Increment view count
        $story->increment('views');

        return view('stories.show', compact('story'));
    }

    /**
     * Rate the specified story.
     */
    public function rate(Request $request, Story $story)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = $request->input('rating');
        
        // Update the average rating
        $story->rating = (($story->rating * $story->rating_count) + $rating) / ($story->rating_count + 1);
        $story->rating_count++;
        $story->save();

        return back()->with('success', 'Thank you for rating this story!');
    }

    /**
     * Show the form for creating a new story.
     */
    public function create()
    {
        return view('admin.stories.create');
    }

    /**
     * Store a newly created story in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // 2MB max
            'image_url' => 'nullable|url',
            'age_range' => 'required|string|max:50',
            'reading_time' => 'required|integer|min:1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['thumbnail'] = $request->file('image')->store('stories', 'public');
        }
        // Handle image URL
        elseif ($request->filled('image_url')) {
            $validated['thumbnail'] = $request->input('image_url');
        }

        Story::create($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story created successfully.');
    }

    /**
     * Show the form for editing the specified story.
     */
    public function edit(Story $story)
    {
        return view('admin.stories.edit', compact('story'));
    }

    /**
     * Update the specified story in storage.
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // 2MB max
            'image_url' => 'nullable|url',
            'age_range' => 'required|string|max:50',
            'reading_time' => 'required|integer|min:1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists and is a local file
            if ($story->thumbnail && !filter_var($story->thumbnail, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($story->thumbnail);
            }
            $validated['thumbnail'] = $request->file('image')->store('stories', 'public');
        }
        // Handle image URL
        elseif ($request->filled('image_url')) {
            $validated['thumbnail'] = $request->input('image_url');
        }

        $story->update($validated);

        // Reload the story to ensure we have the updated data
        $story->refresh();

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified story from storage.
     */
    public function destroy(Story $story)
    {
        // Delete image if exists and is a local file
        if ($story->thumbnail && !filter_var($story->thumbnail, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($story->thumbnail);
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story deleted successfully.');
    }

    // Admin methods will go here...
} 