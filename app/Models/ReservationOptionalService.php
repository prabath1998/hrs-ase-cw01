<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationOptionalService extends Pivot
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
