<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Receipt #{{ $payment->id }}</title>
    <style>
        body { font-family: 'Helvetica', DejaVu Sans, sans-serif; font-size: 13px; color: #333; line-height: 1.4; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; }
        .header p { margin: 2px 0; }
        .details-section { margin-bottom: 30px; }
        .details-table { width: 100%; }
        .details-table td { vertical-align: top; padding: 5px 0; }
        .receipt-for { font-weight: bold; margin-bottom: 5px; }
        .payment-details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .payment-details-table th, .payment-details-table td { border-bottom: 1px solid #ddd; padding: 10px; text-align: left; }
        .payment-details-table th { background-color: #f2f2f2; font-weight: bold; }
        .payment-details-table .text-right { text-align: right; }
        .summary-table { width: 45%; margin-left: 55%; margin-top: 20px; border-collapse: collapse; }
        .summary-table td { padding: 8px; }
        .summary-table .label { text-align: right; }
        .summary-table .value { text-align: right; font-weight: bold; }
        .summary-table .total-paid td { font-size: 18px; font-weight: bold; border-top: 2px solid #333; border-bottom: 2px solid #333; background-color: #eaf7ff; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ccc; padding-top: 10px;}
    </style>
</head>
<body>
    <div class="container">
        @if(optional($reservation)->hotel)
        <div class="header">
            <h1>{{ $reservation->hotel->name }}</h1>
            <p>{{ $reservation->hotel->address }}, {{ $reservation->hotel->city }}</p>
            <p>Phone: {{ $reservation->hotel->phone_number }} | Email: {{ $reservation->hotel->email_address }}</p>
        </div>
        @endif

        <h2 style="text-align: center; margin-bottom: 30px;">PAYMENT RECEIPT</h2>

        <div class="details-section">
            <table class="details-table">
                <tr>
                    <td style="width: 50%;">
                        <div class="receipt-for">Receipt For:</div>
                        @if($billedTo instanceof \App\Models\Customer)
                            {{ $billedTo->first_name }} {{ $billedTo->last_name }}
                        @else {{-- It's a TravelCompany --}}
                            {{ $billedTo->company_name }}
                        @endif
                        <br>
                        {{ optional($billedTo)->address ?? $billedTo->address_line1 }}<br>
                        {{ optional($billedTo)->contact_email ?? $billedTo->email }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Receipt #:</strong> {{ $payment->id }}<br>
                        <strong>Payment Date:</strong> {{ $payment->created_at->format('F j, Y') }}<br>
                        <strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}<br>
                        @if($reservation)
                            <strong>Reference Invoice #:</strong> {{ $payment->bill->bill_number }}<br>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <table class="payment-details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount Paid ($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Payment toward Invoice #{{ $payment->bill->bill_number }}
                        @if($reservation)
                        <br><small>For Reservation #{{ $reservation->id }}</small>
                        @endif
                    </td>
                    <td class="text-right" style="font-size: 16px; font-weight: bold;">
                        {{ number_format($payment->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td class="label">Invoice Total:</td>
                <td class="value">${{ number_format($bill->grand_total, 2) }}</td>
            </tr>
             <tr class="total-paid">
                <td class="label">Amount Paid (This Transaction):</td>
                <td class="value">${{ number_format($payment->amount, 2) }}</td>
            </tr>
             <tr>
                <td class="label">Total Paid on Invoice:</td>
                <td class="value">${{ number_format($bill->amount_paid, 2) }}</td>
            </tr>
             <tr style="font-weight: bold;">
                <td class="label">Remaining Balance:</td>
                <td class="value">${{ number_format($bill->grand_total - $bill->amount_paid, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your payment!</p>
            @if($payment->processedBy)
                <p>Processed by: {{ $payment->processedBy->name }}</p>
            @endif
        </div>
    </div>
</body>
</html>
