<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function activeReservations()
    {
        return $this->reservations()->where('status', '!=', 'cancelled_customer')->orWhere('status', '!=', 'cancelled_system')->orWhere('status', '!=', 'checked_out');
    }

    public function totalSpent()
    {
        return $this->bills()->sum('amount_paid');
    }

    public function totalReservations()
    {
        return $this->reservations()->count();
    }

    public function totalReservationHotels()
    {
        return $this->reservations()->pluck('hotel_id')->unique()->count();
    }

    public function lastMonthReservationCount()
    {
        return $this->reservations()->where('created_at', '>=', now()->subMonth())->count();
    }

    public function activeReservationsCount()
    {
        return $this->reservations()->where('status', '!=', 'cancelled_customer')->orWhere('status', '!=', 'cancelled_system')->orWhere('status', '!=', 'checked_out')->count();
    }
    
    public function getReservationsWithDetails()
    {
        return $this->reservations()->with(['hotel', 'roomType'])->latest()->get()->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'roomName' => $reservation->roomType->name,
                'roomImage' => asset('images/hotel/1/86161620.jpg'), // Placeholder image
                'hotel_name' => $reservation->hotel->name,
                'checkIn' => $reservation->check_in_date,
                'checkOut' => $reservation->check_out_date,
                'guest' => 2, // Placeholder value
                'status' => $reservation->status,
                'total' => $reservation->total_estimated_room_charge,
                'nights' => 6, // Placeholder value
                'amenities' => $reservation->roomType->features ?? [],
            ];
        });
    }
    public function getBillsWithDetails()
    {
        return $this->bills()->with(['reservation', 'reservation.roomType'])->latest()->get()->map(function ($bill) {
            return [
                'id' => $bill->id,
                'date' => $bill->created_at->format('Y-m-d'),
                'description' => $bill->reservation->roomType->name,
                'amount' => $bill->amount_paid,
                'status' => $bill->status,
                'reservationId' => $bill->reservation_id,
                'paymentMethod' => 'VISA ****' . substr($this->user->credit_card_last_four, -4),
            ];
        });
    }
    public function getDashboardData()
    {
        return [
            'reservations' => $this->getReservationsWithDetails(),
            'bills' => $this->getBillsWithDetails(),
            'lastMonthReservationCount' => $this->lastMonthReservationCount(),
            'totalSpent' => $this->totalSpent(),
            'totalReservations' => $this->totalReservations(),
            'totalReservationHotelCount' => $this->totalReservationHotels(),
            'activeReservationsCount' => $this->activeReservationsCount(),
        ];
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
