<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    // HasFactory: لإنشاء بيانات وهمية للتجربة
    // SoftDeletes: تفعيل "الحذف الناعم" (يتم تعليم الحجز كمحذوف في القاعدة دون مسحه فعلياً)
    use HasFactory, SoftDeletes;

    // الحقول المسموح بتعبئتها دفعة واحدة 
    protected $fillable = ['user_id', 'guest_user_id', 'showtime_id', 'status'];

    //  كل حجز "ينتمي إلى" مستخدم واحد مسجل في النظام.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // تسجيله في النظام في حال كان ضيف 
    public function guestUser()
    {
        return $this->belongsTo(GuestUser::class);
    }

    // تحديد وقت العرض الذي ينتمي له
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    // الحجز الواحد قد يتضمن عدة مقاعد، والمقعد الواحد قد يظهر في حجوزات مختلفة (بأوقات مختلفة).
    // مع تحديد السعر

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats')->withPivot('price');
    }

    //  الحجز الواحد يمكن أن يحتوي على عدة دفع.
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
