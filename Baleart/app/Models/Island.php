<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    protected $fillable = ['name'];
    public $timestamps = true;

    /* Relaciones */

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
