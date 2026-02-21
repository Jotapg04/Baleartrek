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
    public $timestamps = true;

    /* Relaciones */

    public function municipality()
    {
        // Relación: municipality_id en la tabla treks apunta al id de municipalities
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function interestingPlaces()
    {
        return $this->belongsToMany(InterestingPlace::class, 'interesting_place_trek')->withPivot('order')->withTimestamps();
    }


    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function getAverageScoreAttribute()
    {
        return $this->meetings->avg('average_score');
    }
}
