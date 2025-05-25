<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function processedBy() // User who processed the payment
    {
        return $this->belongsTo(User::class, 'processed_by_user_id');
    }
}
