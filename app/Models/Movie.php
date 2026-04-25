<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'duration_minutes', 'release_date',
        'poster_image', 'banner_image', 'language', 'rating', 'studio_id'
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function crew()
    {
        return $this->belongsToMany(Crew::class, 'movie_crew')->withPivot('crew_role_id');
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
