<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Hotel;
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


}
