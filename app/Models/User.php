<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar_path'
    ];

    protected $hidden = ['password',];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

