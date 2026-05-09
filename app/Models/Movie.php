<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = [
        'title', 'description', 'duration_minutes', 'release_date',
        'poster_image', 'banner_image', 'language', 'rating', 'studio_id'
    ];

    // ينتمي الفيلم الى استديو
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    // ينتمي الفيلم الى عده تنصنيفات
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    // ينتمي الفيم الى طاقم عمل, عده اشخاص
    public function crew()
    {
        return $this->belongsToMany(Crew::class, 'movie_crew')->withPivot('crew_role_id');
    }

    // يحتوي الفيلم على عده اوقات للعرض
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
    
}
