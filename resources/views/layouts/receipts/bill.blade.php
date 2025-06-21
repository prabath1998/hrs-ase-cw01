<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $bill->bill_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
        }

        .header .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .details-section {
            margin-bottom: 30px;
        }

        .details-table {
            width: 100%;
        }

        .details-table td {
            vertical-align: top;
            padding: 5px 0;
        }

        .bill-to {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .charges-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .charges-table th,
        .charges-table td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .charges-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .charges-table .text-right {
            text-align: right;
        }

        .summary-table {
            width: 45%;
            margin-left: 55%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px;
        }

        .summary-table .label {
            text-align: right;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .grand-total td {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        @if (optional($reservation)->hotel)
            <div class="header">
                {{-- <img src="{{ public_path('images/logo.png') }}" alt="Hotel Logo" class="logo"> --}}
                <h1>{{ $reservation->hotel->name }}</h1>
                <p>{{ $reservation->hotel->address }}, {{ $reservation->hotel->city }}</p>
                <p>Phone: {{ $reservation->hotel->phone_number }} | Email: {{ $reservation->hotel->email_address }}</p>
            </div>
        @endif

        <h2 style="text-align: center; margin-bottom: 30px;">GUEST FOLIO / INVOICE</h2>

        <div class="details-section">
            <table class="details-table">
                <tr>
                    <td style="width: 50%;">
                        <div class="bill-to">Billed To:</div>
                        @if ($billedTo instanceof \App\Models\Customer)
                            {{ $billedTo->first_name }} {{ $billedTo->last_name }}
                        @else
                            {{-- It's a TravelCompany --}}
                            {{ $billedTo->company_name }}<br>
                            Attn: {{ $billedTo->contact_person_name }}
                        @endif
                        <br>
                        {{ optional($billedTo)->address ?? $billedTo->address_line1 }}<br>
                        {{ optional($billedTo)->contact_email ?? $billedTo->email }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Invoice #:</strong> {{ $bill->bill_number }}<br>
                        <strong>Bill Date:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('F j, Y') }}<br>
                        <strong>Payment Status:</strong> <span
                            style="font-weight: bold;">{{ ucwords(str_replace('_', ' ', $bill->payment_status)) }}</span><br>
                        @if ($reservation)
                            <strong>Reservation ID:</strong> {{ $reservation->id }}<br>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if ($reservation)
            <div class="details-section">
                <table class="details-table">
                    <tr>
                        <td style="width: 25%;"><strong>Room Type:</strong></td>
                        <td style="width: 25%;">{{ $reservation->roomType->name }}</td>
                        <td style="width: 25%;"><strong>Guest Name:</strong></td>
                        <td style="width: 25%;">{{ $bill->customer->first_name ?? 'N/A' }}
                            {{ $bill->customer->last_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Check-in:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('F j, Y') }}</td>
                        <td><strong>Check-out:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('F j, Y') }}</td>
                    </tr>
                </table>
            </div>
        @endif

        <table class="charges-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th class="text-right">Amount ($)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Room Charges -->
                <tr>
                    <td>{{ \Carbon\Carbon::parse($bill->reservation->check_in_date)->format('Y-m-d') }}</td>
                    <td>Room Charge ({{ $numberOfNights }} {{ Str::plural('Night', $numberOfNights) }})
                        @if ($reservation->is_suite_booking)
                            - {{ ucwords($reservation->suite_booking_period) }} Rate
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($bill->subtotal_room_charges, 2) }}</td>
                </tr>

                <!-- Optional Services / Bill Items -->
                @if(optional($reservation)->optionalServices->isNotEmpty())
                    @foreach($reservation->optionalServices as $service)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d') }}</td>
                        <td>{{ $service->name }} (x{{ $service->pivot->quantity }}) - Pre-booked</td>
                        <td class="text-right">{{ number_format($service->pivot->price_at_booking * $service->pivot->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="value">$
                    {{ number_format($bill->subtotal_room_charges + $bill->subtotal_optional_services, 2) }}</td>
            </tr>
            @if ($bill->discount_amount_applied > 0)
                <tr>
                    <td class="label">Discount:</td>
                    <td class="value">- $ {{ number_format($bill->discount_amount_applied, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Tax ({{ (float) $bill->tax_percentage_applied }}%):</td>
                <td class="value">$ {{ number_format($bill->tax_amount, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">Grand Total:</td>
                <td class="value">$ {{ number_format($bill->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Payments Received:</td>
                <td class="value">- $ {{ number_format($bill->amount_paid, 2) }}</td>
            </tr>
            <tr class="grand-total" style="background-color: #f2f2f2;">
                <td class="label">Balance Due:</td>
                <td class="value">$ {{ number_format($bill->grand_total - $bill->amount_paid, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            Thank you for staying with us at {{ optional($reservation)->hotel->name }}! We hope to see you again soon.
        </div>
    </div>
</body>

</html>
