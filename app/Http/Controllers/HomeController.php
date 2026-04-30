<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
      //  $movies = Movie::with('categories')->get();
       // return view('home', compact('movies'));

               $todayMovies = Movie::whereHas('showtimes', function ($q) {
        $q->whereDate('show_date', Carbon::today());
    })->get();

    $randomMovies = Movie::inRandomOrder()->take(8)->get();

    $catMovies = Movie::whereHas('categories', function ($q) {
        $q->where('name', 'Family');
    })->get();

   
        return view('home', compact('todayMovies','randomMovies','catMovies'));
     }

    public function showMovie($id)
    {
        $movie = Movie::with(['studio', 'categories', 'crew', 'showtimes' => function($query) {
            $query->whereDate('show_date', '>=', now()->toDateString())->orderBy('show_date')->orderBy('start_time');
        }])->findOrFail($id);

        return view('movies.show', compact('movie'));
    }
}
