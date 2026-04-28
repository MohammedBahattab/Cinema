<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Movie;
use App\Models\Category;
use App\Models\Crew;
use App\Models\Studio;

class MovieController extends Controller
{
    public function search(Request $request)
{
    $query = Movie::query();

    // 1. نص البحث
    if ($request->filled('q')) {
        $query->where('title', 'like', '%' . $request->q . '%');
    }

    // 2. فلتر السنة (استخراج السنة من release_date)
    if ($request->filled('year')) {
        $query->whereYear('release_date', $request->year);
    }

    // 3. فلتر التقييم
    if ($request->filled('rating')) {
        $query->where('rating', '>=', $request->rating);
    }

    // 4. فلتر الاستوديوهات (التعديل الصحيح لموديل Movie)
    if ($request->filled('studios')) {
        // نستخدم studio_id مباشرة لأنها موجودة في الـ fillable والجدول
        $query->whereIn('studio_id', (array) $request->studios);
    }

    // 5. فلتر التصنيفات (علاقة Many-to-Many)
    if ($request->filled('categories')) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->whereIn('categories.id', (array) $request->categories);
        });
    }

    $searchGrid = 'col-12 col-md-6 col-xl-4';

    $movies = $query->get();

       if ($request->ajax()) {
        return view('movies.partials.results', [
            'movies' => $movies,
            'gridClass' => $searchGrid // نمررها هنا لـ AJAX
        ])->render();
    }

    // في حال تحميل الصفحة لأول مرة
    return view('movies.search', [
        'movies' => $movies,
        'gridClass' => $searchGrid,
        'categories' => \App\Models\Category::all(),
        'studios' => \App\Models\Studio::all()
    ]);
}
}
