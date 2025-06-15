<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /* Customer Dashboard */

    public function index()
    {
        // This is customer dashboard
        // $this->checkAuthorization(auth()->user(), ['dashboard.view']);

        $customer = auth()->user();
        if (!$customer) {
            return redirect()->route('home')->with('error', 'You must be logged in to access the dashboard.');
        }

        $reservations = $customer->reservations()->with(['hotel', 'roomType'])->latest()->get();
        $reservations = $reservations->map(function($reservation) {
            return [
                'id' => $reservation->id,
                'roomName' => $reservation->roomType->name,
                'roomImage' => asset('images/hotel/1/86161620.jpg'),
                'hotel_name' => $reservation->hotel->name,
                'checkIn' => $reservation->check_in_date,
                'checkOut' => $reservation->check_out_date,
                'guest' => 2,
                'status' => $reservation->status,
                'total' => $reservation->total_estimated_room_charge,
                'nights' => 6,
                'amenities' => $reservation->roomType->pluck('features')->flatten()->unique()->values(),
            ];
        });

        $bills = $customer->bills()->with(['reservation', 'reservation.roomType'])->latest()->get();
        $bills = $bills->map(function($bill) use ($customer) {
            return [
                'id' => $bill->id,
                'date' => $bill->created_at->format('Y-m-d'),
                'description' => $bill->reservation->roomType->name,
                'amount' => $bill->amount_paid,
                'status' => $bill->status,
                'reservationId' => $bill->reservation_id,
                'paymentMethod' => 'VISA ****'.$customer->credit_card_last_four,
            ];
        });
        // dd($reservations);

        return view('pages.dashboard.index', compact('reservations', 'bills'));
    }

}
