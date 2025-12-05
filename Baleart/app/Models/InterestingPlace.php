<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestingPlace extends Model
{
    protected $fillable = [
        'name',
        'gps_coordinates',
        'place_type_id'
    ];

    public $timestamps = false;

    /* Relaciones */

    public function type()
    {
        return $this->belongsTo(PlaceType::class, 'place_type_id');
    }

    public function treks()
    {
        return $this->belongsToMany(Trek::class, 'interesting_place_trek')->withPivot('order')->withTimestamps();
    }
}
