<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name', 'country', 'founded_year'];

    // يمكن للاستديو ان يحتوي على عدة افلام
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
