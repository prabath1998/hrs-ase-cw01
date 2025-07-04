<?php

declare(strict_types=1);

namespace App\Services;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Hotel;
use App\Models\Setting;
use App\Models\TravelCompany;
use App\Models\User;

use App\Models\RoomType;
use Hash;
use Illuminate\Support\Carbon;

class ReservationService
{
     public function generateAndGetBill(Reservation $reservation, string $status = 'pending'): Bill
    {
        $roomCharges = $reservation->total_estimated_room_charge;

        $optionalServiceCharges = $reservation->subTotalOptionalServices();

        $subtotal = $roomCharges + $optionalServiceCharges;
        $taxPercentage = Setting::where('option_name', 'tax_rate')->value('option_value') ?? 0;
        $taxAmount = $subtotal * ($taxPercentage / 100);
        $discountAmount = $subtotal * (($reservation->applied_discount_percentage ?? 0) / 100);
        $grandTotal = ($subtotal - $discountAmount) + $taxAmount;

        return Bill::create([
            'reservation_id' => $reservation->id,
            'customer_id' => $reservation->customer_id,
            'travel_company_id' => $reservation->travel_company_id,
            'bill_number' => 'INV-' . time() . '-' . $reservation->id,
            'bill_date' => now('Asia/Colombo'),
            'due_date' => now('Asia/Colombo')->addDays(30),
            'subtotal_room_charges' => $roomCharges,
            'subtotal_optional_services' => $optionalServiceCharges,
            'total_amount' => $subtotal,
            'tax_percentage_applied' => $taxPercentage,
            'tax_amount' => $taxAmount,
            'discount_amount_applied' => $discountAmount,
            'grand_total' => $grandTotal,
            'amount_paid' => 0,
            'payment_status' => $status,
            'generated_by_user_id' => auth()->id() ?? 1,
        ]);
    }
}
