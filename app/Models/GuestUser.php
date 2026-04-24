<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'age', 'phone_number', 'email'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
