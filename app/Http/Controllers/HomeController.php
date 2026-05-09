<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
   ///عرض الافلام بناء على وقت العرض لنفس اليوم

               $todayMovies = Movie::whereHas('showtimes', function ($q) {
        $q->whereDate('show_date', Carbon::today());
    })->get();

    //جلب الافلام عشوائيا
    $randomMovies = Movie::inRandomOrder()->take(8)->get();

    //عرض الافلام بناء على تصنيف محدد مثل عائلي

    $catMovies = Movie::whereHas('categories', function ($q) {
        $q->where('name', 'Family');
    })->get();

   
        return view('home', compact('todayMovies','randomMovies','catMovies'));
     }

     //عرض الفيلم مع  التفاصيل مثل الاستديو و التصنيفات
    public function showMovie($id)
    {
        $movie = Movie::with(['studio', 'categories', 'crew', 'showtimes' => function($query) {
            $query->whereDate('show_date', '>=', now()->toDateString())->orderBy('show_date')->orderBy('start_time');
        }])->findOrFail($id);

        return view('movies.show', compact('movie'));
    }
}
