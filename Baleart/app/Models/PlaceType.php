<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    protected $fillable = ['name'];

    /* Relaciones */

    public function interestingPlaces()
    {
        return $this->hasMany(InterestingPlace::class);
    }
}
