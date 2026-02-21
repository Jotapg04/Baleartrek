<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'dni',
        'phone',
        'email',
        'password',
        'role_id',
        'active'
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /* Relaciones */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // meetings en los que participa como excursionista
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class);
    }

    // meetings donde actúa como guía responsable
    public function meetingsAsResponsible()
    {
        return $this->hasMany(Meeting::class, 'guide_responsible_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
