<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trek extends Model
{
    protected $fillable = [
        'name',
        'reg_number',
        'municipality_id',
        'available'
    ];

    /* Relaciones */

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function interestingPlaces()
    {
        return $this->belongsToMany(InterestingPlace::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    /* OPCIONAL: cálculo dinámico sin triggers */
    public function getAverageScoreAttribute()
    {
        return $this->meetings->avg('average_score');
    }
}
