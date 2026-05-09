<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use HasFactory, Notifiable, SoftDeletes;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'age',
        'phone_number',
    ];

    // اخفاء كلمات السر  وامكانية التذكر
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // مصفوفة تحويل انواع البيانات تقوم بتحويل قيم الحقول تلقائياً عند جلبها من قاعدة البيانات أو تخزينها
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // كل مستخدم ينتمي الى صلاحية دور محدد
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // يمكن للمستخم ان ينتمي لعده حجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
