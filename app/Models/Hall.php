<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name', 'total_rows', 'seats_per_row'];

    // كل صالة تحتوي على عده مقاعد
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    // يمكن للصالة ان تنتمي الى عده اوقات للعرض
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
