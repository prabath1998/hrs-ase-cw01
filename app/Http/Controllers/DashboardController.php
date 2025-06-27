<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Models\Customer;
use App\Models\OptionalService;

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
            $dashboardUser = $user->customer;
        } elseif($user->travelCompany) {
            $dashboardUser = $user->travelCompany;
        } else {
            return redirect()->route('home')->with('error', 'You must be a customer to access the dashboard.');
        }

        $reservationData = $this->customerService->getCustomerDashboardData($dashboardUser);
        $billData = $this->customerService->getCustomerBills($dashboardUser);

        $reservations = $reservationData['reservations'];
        $totalReservations = $reservationData['totalReservations'];
        $totalReservationHotelCount = $reservationData['totalReservationHotelCount'];
        $lastMonthReservationCount = $reservationData['lastMonthReservationCount'];
        $activeReservationsCount = $reservationData['activeReservationsCount'];
        $totalSpent = $billData['totalSpent'];
        $bills = $billData['bills'];
        $availableOptionalServices = OptionalService::all()->map(function($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
            ];
        });

        $customerDetails = $this->customerService->getCustomerDetails($dashboardUser);

        return view('pages.dashboard.index', compact('reservations', 'bills', 'lastMonthReservationCount', 'totalSpent', 'totalReservations', 'totalReservationHotelCount', 'availableOptionalServices', 'customerDetails'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->customer) {
            return redirect()->route('home')->with('error', 'You must be a customer to update your profile.');
        }

        $customer = $user->customer;
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = $this->customerService->updateCustomerDetails($customer, $data);

        // Password validation if password is provided
        if($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required|string|current_password',
                'new_password' => 'required|string|min:8|confirmed',
                'confirm_password' => 'required|string|min:8',
            ]);

            if (!\Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $newPasswordHash = \Hash::make($request->input('new_password'));
            $confirmPasswordHash = \Hash::make($request->input('confirm_password'));

            if ($newPasswordHash !== $confirmPasswordHash) {
                return redirect()->back()->withErrors(['new_password' => 'New password and confirm password do not match.']);
            }

            auth()->user()->update([
                'password' => $newPasswordHash,
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

}
