<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['movie_id', 'hall_id', 'show_date', 'start_time', 'end_time', 'price'];

    // وقت العرض ينتمي لفيلم واحد
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    //  وقت العرض ينتمي لصالة واحده
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    // وقت العرض يمكن أن يحتوي على عدة حجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
