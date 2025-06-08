<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'images' => 'array',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}
