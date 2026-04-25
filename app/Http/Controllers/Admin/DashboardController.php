<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\Hall;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalShowtimes = Showtime::count();
        $totalBookings = Booking::count();
        $totalHalls = Hall::count();
        $recentBookings = Booking::with([
            'user', 
            'guestUser', 
            'showtime.movie' => function($q) { $q->withTrashed(); }
        ])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMovies', 'totalShowtimes', 'totalBookings', 'totalHalls', 'recentBookings'
        ));
    }
}
