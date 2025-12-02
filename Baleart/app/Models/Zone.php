<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    /* Relaciones */

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
