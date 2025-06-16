<?php

declare(strict_types=1);

namespace App\Services;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Hotel;
use App\Models\User;

use App\Models\RoomType;
use Hash;
use Illuminate\Support\Carbon;

class CustomerService
{

    public function getCustomerDashboardData(Customer $customer): array
    {
        $reservations = $this->getCustomerReservations($customer);
        $totalReservations = $reservations->count();
        $totalReservationHotelCount = $reservations->pluck('hotel_id')->unique()->count();
        $lastMonthReservationCount = $reservations->where('created_at', '>=', now()->subMonth())->count();
        $activeReservations = $reservations->where('status', '!=', 'cancelled')->count();

        $formattedReservations = $reservations->map(function($reservation) {

            $roomCharge = $reservation->total_estimated_room_charge;
            $optionalServicesCharge = $reservation->optionalServices->sum(function($service) {
                return $service->pivot->quantity * $service->pivot->price_at_booking;
            });
            $subtotal = $roomCharge + $optionalServicesCharge;
            $discountTotal = ($subtotal * ($reservation->applied_discount_percentage ?? 0)) / 100;
            $taxes = $reservation->taxes ?? 0;
            $grandTotal = ($subtotal - $discountTotal) + $taxes;

            return [
                'id' => $reservation->id,
                'roomName' => $reservation->roomType->name,
                'roomImage' => asset('images/hotel/1/86161620.jpg'),
                'roomType' => $reservation->roomType->name,
                'roomTypeId' => $reservation->room_type_id,
                'hotelName' => $reservation->hotel->name,
                'checkIn' => $reservation->check_in_date,
                'checkOut' => $reservation->check_out_date,
                'guests' => 2,
                'status' => $reservation->status,
                'total' => $reservation->total_estimated_room_charge,
                'nights' => Carbon::parse($reservation->check_in_date)->diffInDays(Carbon::parse($reservation->check_out_date)),
                'amenities' => $reservation->roomType->pluck('features')->flatten()->unique()->values(),
                'optionalServices' => $reservation->optionalServices->map(function($service) {
                        return [
                            'id' => $service->id,
                            'name' => $service->name,
                            'quantity' => $service->pivot->quantity,
                            'price' => $service->pivot->price_at_booking,
                        ];
                    }),
                'priceBreakdown' => [
                    'roomCharge' => $roomCharge,
                    'optionalServicesCharge' => $optionalServicesCharge,
                    'subTotal' => $subtotal,
                    'discountTotal' => $discountTotal,
                    'taxes' => $taxes,
                    'grandTotal' => $grandTotal,
                ],
            ];
        });

        return [
            'reservations' => $formattedReservations,
            'totalReservations' => $totalReservations,
            'totalReservationHotelCount' => $totalReservationHotelCount,
            'lastMonthReservationCount' => $lastMonthReservationCount,
            'activeReservationsCount' => $activeReservations,
        ];
    }
    public function getCustomerBills(Customer $customer): array
    {
        $bills = $customer->bills()->with(['reservation', 'reservation.roomType'])->latest()->get();
        $totalSpent = $bills->sum('amount_paid');

        $formattedBills = $bills->map(function($bill) use ($customer) {
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

        return [
            'bills' => $formattedBills,
            'totalSpent' => $totalSpent,
        ];
    }

    public function getCustomerReservations(Customer $customer)
    {
        return $customer->reservations()->with(['hotel', 'roomType', 'optionalServices'])->latest()->get();
    }

    public function getCustomerDetails(Customer $customer): array
    {
        return [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'created_at' => $customer->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $customer->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function updateCustomerDetails(Customer $customer, array $data): Customer
    {
        $customer->first_name = $data['first_name'] ?? $customer->first_name;
        $customer->last_name = $data['last_name'] ?? $customer->last_name;
        // $customer->email = $data['email'] ?? $customer->email;
        $customer->phone_number = $data['phone'] ?? $customer->phone;
        $customer->address = $data['address'] ?? $customer->address;

        $customer->save();

        return $customer;
    }
}
