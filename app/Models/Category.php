<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name'];

    // التصنيفات تنتمي الى عده افلام
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_category');
    }
}
