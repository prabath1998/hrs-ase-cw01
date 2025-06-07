<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RoomType extends Model
{
    /** @use HasFactory<\Database\Factories\RoomTypeFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'features' => 'array', // Or 'object'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function scopeWithAvailability(Builder $query, Hotel $hotel, Carbon $checkInDate, Carbon $checkOutDate): Builder
    {
        return $query->where('hotel_id', $hotel->id)
            ->withCount(['rooms as total_rooms_of_type' => function ($query) use ($hotel) {
                // Count all physical rooms of this type for the hotel
                $query->where('hotel_id', $hotel->id);
            }])
            ->withCount(['reservations as booked_rooms_count' => function ($query) use ($hotel, $checkInDate, $checkOutDate) {
                // Count the number of conflicting reservations for this room type at this hotel
                $query->where('hotel_id', $hotel->id)
                      // Filter active reservations
                      ->whereIn('status', ['confirmed_guaranteed', 'confirmed_no_cc_hold', 'checked_in'])
                      // Filter conflicting dates
                      ->where(function ($q) use ($checkInDate, $checkOutDate) {
                          $q->where('check_in_date', '<', $checkOutDate)
                            ->where('check_out_date', '>', $checkInDate);
                      });
            }])
            ->havingRaw('total_rooms_of_type > booked_rooms_count'); // Return types with at least one room available
    }
}
