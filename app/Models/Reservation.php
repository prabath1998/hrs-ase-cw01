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
        return $this->belongsToMany(OptionalService::class)
            ->withPivot('quantity', 'price_at_booking')
            ->using(ReservationOptionalService::class)
            ->withTimestamps();
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function totalEstimatedCost()
    {
        $totalCost = $this->total_estimated_room_charge + $this->optionalServices->sum(function ($service) {
            return $service->pivot->quantity * $service->pivot->price_at_booking;
        });
        $discount = $totalCost * ($this->applied_discount_percentage ?? 0 / 100);
        $totalCost -= $discount;
        return \Illuminate\Support\Number::currency($totalCost, 'USD');
    }

    public function statusLabel()
    {
        return match ($this->status) {
            'pending_confirmation' => __('Pending Payment'),
            'confirmed_guaranteed' => __('Confirmed'),
            'confirmed_no_cc_hold' => __('Confirmed - No CC Hold'),
            'checked_in' => __('Checked In'),
            'checked_out' => __('Checked Out'),
            'cancelled_customer' => __('Cancelled by Customer'),
            'cancelled_system' => __('Cancelled by System'),
            'no_show' => __('No Show'),
            'block_booking_pending_names' => __('Block Booking - Pending Names'),
            'completed' => __('Completed'),
            default => __('Unknown Status'),
        };
    }

    public function statusColor()
    {
        return match ($this->status) {
            'pending_confirmation' => 'bg-yellow-100 text-yellow-800',
            'confirmed_guaranteed' => 'bg-green-100 text-green-800',
            'confirmed_no_cc_hold' => 'bg-yellow-100 text-yellow-800',
            'checked_in' => 'bg-blue-100 text-blue-800',
            'checked_out' => 'bg-gray-100 text-gray-800',
            'cancelled_customer' => 'bg-red-100 text-red-800',
            'cancelled_system' => 'bg-red-200 text-red-900',
            'no_show' => 'bg-orange-100 text-orange-800',
            'block_booking_pending_names' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-200 text-green-900',
            default => 'bg-gray-200 text-gray-900',
        };
    }


}
