<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationOptionalService extends Pivot
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function optionalService()
    {
        return $this->belongsTo(OptionalService::class);
    }
}
