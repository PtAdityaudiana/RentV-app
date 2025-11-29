<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'type','brand','model','plate_number','color','year', 'price_per_day', 'photo_path', 'status', 'notes'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
