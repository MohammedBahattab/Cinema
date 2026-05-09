<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['booking_id', 'payment_method', 'payment_status', 'amount', 'paid_at'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // ينتمي الدفع الى الحجز
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
