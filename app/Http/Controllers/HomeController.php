<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('categories')->get();
        return view('home', compact('movies'));
    }

    public function showMovie($id)
    {
        $movie = Movie::with(['studio', 'categories', 'crew', 'showtimes' => function($query) {
            $query->whereDate('show_date', '>=', now()->toDateString())->orderBy('show_date')->orderBy('start_time');
        }])->findOrFail($id);

        return view('movies.show', compact('movie'));
    }
}
