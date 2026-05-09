<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;

    protected $table = 'crew';

    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = ['name'];

    // يمكن ان ينتمي الشخص الى عده افلام ودور
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_crew')->withPivot('crew_role_id');
    }
}
