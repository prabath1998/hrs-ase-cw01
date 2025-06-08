<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Hotel;
use App\Models\RoomType;
use Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class HotelService
{
    public function getHotels(): LengthAwarePaginator
    {
        $query = Hotel::query();
        $search = request()->input('search');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('contact_email', 'like', "%{$search}%");
        }

        $role = request()->input('role');
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        return $query->latest()->paginate(config('settings.default_pagination') ?? 10);
    }

    public function checkRoomAvailability(Hotel $hotel, string $checkInDate, string $checkOutDate, RoomType $roomType): bool
    {
        $reservations = $hotel->reservations()
            ->where('room_type_id', $roomType->id)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<=', $checkInDate)
                            ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->exists();

        return !$reservations;
    }


}
