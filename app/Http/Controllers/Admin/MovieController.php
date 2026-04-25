<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Studio;
use App\Models\Category;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('studio', 'categories')->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $studios = Studio::all();
        $categories = Category::all();
        return view('admin.movies.create', compact('studios', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'release_date' => 'nullable|date',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:50',
            'rating' => 'nullable|string|max:10',
            'studio_id' => 'nullable|exists:studios,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($request->hasFile('poster_image')) {
            $validated['poster_image'] = $request->file('poster_image')->store('movies', 'public');
        }

        $movie = Movie::create($validated);

        if (!empty($validated['categories'])) {
            $movie->categories()->attach($validated['categories']);
        }

        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }

    public function edit(Movie $movie)
    {
        $studios = Studio::all();
        $categories = Category::all();
        return view('admin.movies.edit', compact('movie', 'studios', 'categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'release_date' => 'nullable|date',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:50',
            'rating' => 'nullable|string|max:10',
            'studio_id' => 'nullable|exists:studios,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($request->hasFile('poster_image')) {
            // Delete old image if it exists and is stored locally
            if ($movie->poster_image && !str_starts_with($movie->poster_image, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($movie->poster_image);
            }
            $validated['poster_image'] = $request->file('poster_image')->store('movies', 'public');
        } else {
            unset($validated['poster_image']);
        }

        $movie->update($validated);

        if (isset($validated['categories'])) {
            $movie->categories()->sync($validated['categories']);
        } else {
            $movie->categories()->detach();
        }

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
