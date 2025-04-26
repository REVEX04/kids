<?php

namespace App\Http\Controllers;

use App\Models\Animeaux;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnimeauxController extends Controller
{
    public function index()
    {
        $types = ['mammifere', 'oiseau', 'reptile', 'amphibien', 'invertebré', 'poisson'];
        return view('animeaux.index', compact('types'));
    }

    public function type($type)
    {
        $animaux = Animeaux::where('type', $type)->get();
        return view('animeaux.type', compact('animaux', 'type'));
    }

    public function show(Animeaux $animal)
    {
        return view('animeaux.show', compact('animal'));
    }

    public function create()
    {
        $types = ['mammifere', 'oiseau', 'reptile', 'amphibien', 'invertebré', 'poisson'];
        return view('admin.animeaux.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'type' => 'required|in:mammifere,oiseau,reptile,amphibien,invertebré,poisson',
            'espece' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('image')->store('animeaux', 'public');
        
        Animeaux::create([
            'nom' => $validated['nom'],
            'type' => $validated['type'],
            'espece' => $validated['espece'],
            'description' => $validated['description'],
            'image_path' => $imagePath
        ]);

        return redirect()->route('admin.animeaux.index')->with('success', 'Animal ajouté avec succès!');
    }

    public function edit(Animeaux $animal)
    {
        $types = ['mammifere', 'oiseau', 'reptile', 'amphibien', 'invertebré', 'poisson'];
        return view('admin.animeaux.edit', compact('animal', 'types'));
    }

    public function update(Request $request, Animeaux $animal)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'type' => 'required|in:mammifere,oiseau,reptile,amphibien,invertebré,poisson',
            'espece' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('animeaux', 'public');
            $animal->image_path = $imagePath;
        }

        $animal->update([
            'nom' => $validated['nom'],
            'type' => $validated['type'],
            'espece' => $validated['espece'],
            'description' => $validated['description']
        ]);

        return redirect()->route('admin.animeaux.index')->with('success', 'Animal modifié avec succès!');
    }

    public function destroy(Animeaux $animal)
    {
        $animal->delete();
        return redirect()->route('admin.animeaux.index')->with('success', 'Animal supprimé avec succès!');
    }
} 