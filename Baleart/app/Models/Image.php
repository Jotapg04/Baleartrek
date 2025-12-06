<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{

    use HasFactory;

    protected $fillable = [
        'comment_id',
        'url'
    ];

    public $timestamps = true;

    /* Relaciones */
    
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
