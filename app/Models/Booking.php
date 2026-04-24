<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'guest_user_id', 'showtime_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guestUser()
    {
        return $this->belongsTo(GuestUser::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats')->withPivot('price');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
