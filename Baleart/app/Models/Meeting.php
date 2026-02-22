<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
   protected $fillable = [
        'trek_id',
        'day',
        'time',
        'guide_responsible_id',
        'totalScore',
        'countScore',
        'appDateIni',
        'appDateEnd'
    ];
    public $timestamps = true;

    /* Relaciones */

    public function trek()
    {
        return $this->belongsTo(Trek::class);
    }

    public function guideResponsible()
    {
        return $this->belongsTo(User::class, 'guide_responsible_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    public function getAverageScoreAttribute()
    {
        return $this->countScore == 0
            ? null
            : round($this->totalScore / $this->countScore, 2);
    }
}
