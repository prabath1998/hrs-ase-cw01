<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Models\Customer;

class DashboardController extends Controller
{
    /* Customer Dashboard */

    public function __construct(private readonly CustomerService $customerService)
    {
        //
    }

    public function index()
    {
        // This is customer dashboard
        // $this->checkAuthorization(auth()->user(), ['dashboard.view']);
        

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('home')->with('error', 'You must be logged in to access the dashboard.');
        }

        if($user->customer) {
            $customer = $user->customer;
        } else {
            return redirect()->route('home')->with('error', 'You must be a customer to access the dashboard.');
        }

        $reservationData = $this->customerService->getCustomerDashboardData($customer);
        $billData = $this->customerService->getCustomerBills($customer);

        $reservations = $reservationData['reservations'];
        $totalReservations = $reservationData['totalReservations'];
        $totalReservationHotelCount = $reservationData['totalReservationHotelCount'];
        $lastMonthReservationCount = $reservationData['lastMonthReservationCount'];
        $activeReservationsCount = $reservationData['activeReservationsCount'];
        $totalSpent = $billData['totalSpent'];
        $bills = $billData['bills'];

        return view('pages.dashboard.index', compact('reservations', 'bills', 'lastMonthReservationCount', 'totalSpent', 'totalReservations', 'totalReservationHotelCount'));
    }

}
