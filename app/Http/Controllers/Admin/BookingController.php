<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'user', 
            'guestUser', 
            'showtime.movie' => function($q) { $q->withTrashed(); }, 
            'showtime.hall', 
            'payments'
        ])
            ->latest()
            ->paginate(15);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'user', 
            'guestUser', 
            'showtime.movie' => function($q) { $q->withTrashed(); }, 
            'showtime.hall', 
            'seats', 
            'payments'
        ]);
        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
