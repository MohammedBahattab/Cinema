<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name'];

    // كل دور ينتمي له عده مستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
