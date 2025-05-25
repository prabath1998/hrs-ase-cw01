<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /** @use HasFactory<\Database\Factories\BillFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function travelCompany()
    {
        return $this->belongsTo(TravelCompany::class);
    }

    public function generatedBy() // User who generated the bill
    {
        return $this->belongsTo(User::class, 'generated_by_user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
