<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['full_name', 'age', 'phone_number', 'email'];

    // يمكن للمستخم ان ينتمي لعده حجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
