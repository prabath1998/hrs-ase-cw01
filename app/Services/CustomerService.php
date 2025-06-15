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
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{

    public function getCustomerDashboardData(Customer $customer): array
    {
        $reservations = $customer->reservations()->with(['hotel', 'roomType'])->latest()->get();
        $totalReservations = $reservations->count();
        $totalReservationHotelCount = $reservations->pluck('hotel_id')->unique()->count();
        $lastMonthReservationCount = $reservations->where('created_at', '>=', now()->subMonth())->count();
        $activeReservations = $reservations->where('status', '!=', 'cancelled')->count();

        $formattedReservations = $reservations->map(function($reservation) {
            return [
                'id' => $reservation->id,
                'roomName' => $reservation->roomType->name,
                'roomImage' => asset('images/hotel/1/86161620.jpg'),
                'roomType' => $reservation->roomType->name,
                'roomTypeId' => $reservation->room_type_id,
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

    public function getCustomerReservations(Customer $customer): LengthAwarePaginator
    {
        return $customer->reservations()->with(['hotel', 'roomType'])->latest()->paginate(10);
    }

    public function getCustomerDetails(Customer $customer): array
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'created_at' => $customer->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $customer->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function updateCustomerDetails(Customer $customer, array $data): Customer
    {
        $customer->name = $data['name'] ?? $customer->name;
        $customer->email = $data['email'] ?? $customer->email;
        $customer->phone = $data['phone'] ?? $customer->phone;
        $customer->address = $data['address'] ?? $customer->address;

        if (isset($data['password']) && !empty($data['password'])) {
            $customer->password = Hash::make($data['password']);
        }

        $customer->save();

        return $customer;
    }

    public function getCustomerById(int $id): ?Customer
    {
        return Customer::find($id);
    }

    public function getCustomerByEmail(string $email): ?Customer
    {
        return Customer::where('email', $email)->first();
    }

    public function getAllCustomers(): LengthAwarePaginator
    {
        return Customer::paginate(10);
    }

    public function createCustomer(array $data): Customer
    {
        $customer = new Customer();
        $customer->name = $data['name'];
        $customer->email = $data['email'];
        $customer->phone = $data['phone'] ?? null;
        $customer->address = $data['address'] ?? null;
        $customer->password = Hash::make($data['password']);
        $customer->save();

        return $customer;
    }

    public function deleteCustomer(Customer $customer): bool
    {
        return $customer->delete();
    }
}