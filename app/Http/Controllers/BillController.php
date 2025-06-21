<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillController extends Controller
{
    public function showReceipt(Bill $bill)
    {
        $bill->load([
            'customer',
            'travelCompany',
            'reservation.hotel',
            'reservation.roomType',
            'reservation.room',
            'reservation.optionalServices',
            'payments'
        ]);

        $reservation = $bill->reservation;

        $numberOfNights = 0;
        if ($reservation) {
            $numberOfNights = Carbon::parse($reservation->check_in_date)
                ->diffInDays(Carbon::parse($reservation->check_out_date));
        }

        $billedTo = $bill->customer ?? $bill->travel_company;

        return view('backend.pages.bills.show', [
            'bill' => $bill,
            'reservation' => $reservation,
            'billedTo' => $billedTo,
            'numberOfNights' => $numberOfNights,
        ]);
    }
}
