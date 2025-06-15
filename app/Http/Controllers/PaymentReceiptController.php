<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceiptController extends Controller
{
    public function download(Payment $payment)
    {
        $user = Auth::user();
        $isOwner = $payment->bill->customer->user_id === $user->id;
        $isTravelCompany = $payment->bill->travel_company_id === optional($user->travelCompany)->id;

        if (!$isOwner && !$isTravelCompany) {
            abort(403, 'Unauthorized action.');
        }

        // --- Data Preparation ---
        // Eager load all related data to avoid multiple queries
        $payment->load('bill.reservation.hotel', 'bill.customer', 'processedBy');

        // You can get some hotel details from your SystemConfiguration seeder data
        // For example:
        // $hotelName = \App\Models\SystemConfiguration::where('setting_key', 'hotel_name')->first()->setting_value ?? 'Grand Serendib Hotel';

        $data = [
            'payment' => $payment,
            'bill' => $payment->bill,
            'reservation' => $payment->bill->reservation,
            'customer' => $payment->bill->customer,
            'hotel' => $payment->bill->reservation->hotel, // Assumes this relationship exists
            'receipt_issue_date' => now()->format('F j, Y'),
        ];

        // --- PDF Generation ---
        $pdf = Pdf::loadView('receipts.template', $data);

        // Define a filename for the download
        $fileName = 'receipt-' . $payment->id . '-bill-' . $payment->bill->bill_number . '.pdf';

        // --- Download Response ---
        // Use stream() to show in browser, download() to force download
        return $pdf->download($fileName);
    }
}
