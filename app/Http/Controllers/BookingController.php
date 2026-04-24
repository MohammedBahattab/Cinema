<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Booking;
use App\Models\GuestUser;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class BookingController extends Controller
{
    public function selectSeats(Showtime $showtime)
    {
        $showtime->load(['movie', 'hall.seats']);
        
        $bookedSeats = DB::table('booking_seats')
            ->where('showtime_id', $showtime->id)
            ->pluck('seat_id')
            ->toArray();

        return view('booking.seats', compact('showtime', 'bookedSeats'));
    }

    public function checkout(Request $request, Showtime $showtime)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
        ]);

        $seats = $request->input('seats');
        $totalPrice = count($seats) * $showtime->price;

        return view('booking.checkout', compact('showtime', 'seats', 'totalPrice'));
    }

    public function store(Request $request, Showtime $showtime)
    {
        // Validation handles guest user fields if not authenticated
        $rules = [
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
        ];

        if (!Auth::check()) {
            $rules['full_name'] = 'required|string|max:255';
            $rules['age'] = 'nullable|integer|min:1';
            $rules['phone_number'] = 'required|string|max:20';
            $rules['email'] = 'nullable|email|max:255';
        }

        $validated = $request->validate($rules);
        $seats = $validated['seats'];

        DB::beginTransaction();

        try {
            $userId = null;
            $guestUserId = null;

            if (Auth::check()) {
                $userId = Auth::id();
            } else {
                $guestUser = GuestUser::create([
                    'full_name' => $validated['full_name'],
                    'age' => $validated['age'] ?? null,
                    'phone_number' => $validated['phone_number'],
                    'email' => $validated['email'] ?? null,
                ]);
                $guestUserId = $guestUser->id;
            }

            $booking = Booking::create([
                'user_id' => $userId,
                'guest_user_id' => $guestUserId,
                'showtime_id' => $showtime->id,
                'status' => 'confirmed'
            ]);

            $totalAmount = 0;
            $bookingSeats = [];
            foreach ($seats as $seatId) {
                $bookingSeats[] = [
                    'booking_id' => $booking->id,
                    'showtime_id' => $showtime->id,
                    'seat_id' => $seatId,
                    'price' => $showtime->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalAmount += $showtime->price;
            }

            // This will throw QueryException if duplicate unique constraint is hit
            DB::table('booking_seats')->insert($bookingSeats);

            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => 'cash', // Defaulting for MVP
                'payment_status' => 'completed',
                'amount' => $totalAmount,
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('booking.invoice', $booking->id)->with('success', 'Booking completed successfully!');

        } catch (QueryException $e) {
            DB::rollBack();
            // 23000 is standard SQL integrity constraint violation code
            if ($e->getCode() == '23000' || $e->getCode() == 23000) {
                return redirect()->route('booking.seats', $showtime->id)
                    ->with('error', 'One or more selected seats were just booked by someone else. Please select different seats.');
            }
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('booking.seats', $showtime->id)
                ->with('error', 'An error occurred while processing your booking. Please try again.');
        }
    }

    public function invoice(Booking $booking)
    {
        $booking->load(['user', 'guestUser', 'showtime.movie', 'showtime.hall', 'seats', 'payments']);
        return view('booking.invoice', compact('booking'));
    }
}
