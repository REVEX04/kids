<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Public methods
    public function index()
    {
        $categories = Category::withCount('stories')
            ->orderBy('order')
            ->get();

        return view('welcome', compact('categories'));
    }

    public function show(Category $category)
    {
        $stories = $category->stories()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('categories.show', compact('category', 'stories'));
    }

    // Admin methods
    public function adminIndex()
    {
        $categories = Category::withCount('stories')
            ->orderBy('order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory();
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory();
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    protected function validateCategory()
    {
        return request()->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'color' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'order' => 'required|integer|min:0',
        ]);
    }
} 