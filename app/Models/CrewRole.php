<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrewRole extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name'];
}
