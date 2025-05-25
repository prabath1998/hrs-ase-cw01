<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function travelCompany()
    {
        return $this->belongsTo(TravelCompany::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookedBy() // User who made the booking
    {
        return $this->belongsTo(User::class, 'booked_by_user_id');
    }

    public function optionalServices()
    {
        return $this->belongsToMany(OptionalService::class, 'reservation_optional_services')
            ->withPivot('quantity', 'price_at_booking')
            ->using(ReservationOptionalService::class)
            ->withTimestamps();
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
