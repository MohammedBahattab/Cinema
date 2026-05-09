<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    // عرض صفحة وقت العرض الخاصه بالفيلم
    public function index()
    {
        $showtimes = Showtime::with(['movie' => function($q) {
            $q->withTrashed();
        }, 'hall'])->get();
        return view('admin.showtimes.index', compact('showtimes'));
    }

    // الانشاء مع تحديد صالة العرض
    public function create()
    {
        $movies = Movie::all();
        $halls = Hall::all();
        return view('admin.showtimes.create', compact('movies', 'halls'));
    }

    // تخزين البيانات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'show_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:0',
        ]);

        Showtime::create($validated);
        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime created successfully.');
    }

    // حذف وقت العرض

    public function destroy(Showtime $showtime)
    {
        $showtime->delete();
        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime deleted successfully.');
    }
}
