<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function downloadReceipt($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        $payment->load([
            'bill.customer',
            'bill.travelCompany',
            'bill.reservation.hotel',
            'processedBy'
        ]);

        $data = [
            'payment' => $payment,
            'bill' => $payment->bill,
            'reservation' => $payment->bill->reservation,
            'billedTo' => $payment->bill->customer ?? $payment->bill->travelCompany,
        ];

        $pdf = Pdf::loadView('layouts.receipts.payment', $data);
        $fileName = 'payment-receipt-' . $payment->id . '-for-invoice-' . $payment->bill->bill_number . '.pdf';

        return $pdf->download($fileName);
    }
}
