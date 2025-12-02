<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = [
        'name',
        'island_id',
        'zone_id'
    ];

    public $timestamps = false;

    /* Relaciones */

    public function island()
    {
        return $this->belongsTo(Island::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function treks()
    {
        return $this->hasMany(Trek::class);
    }
}
