<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionalService extends Model
{
    /** @use HasFactory<\Database\Factories\OptionalServiceFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_optional_services')
            ->withPivot('quantity', 'price_at_booking')
            ->using(ReservationOptionalService::class)
            ->withTimestamps();
    }
}
