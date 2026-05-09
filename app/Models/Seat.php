<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['hall_id', 'row_number', 'seat_number'];

    // ينتمي المقعد الى صالة
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
