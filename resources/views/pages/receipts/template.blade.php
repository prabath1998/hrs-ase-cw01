<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payment Receipt #{{ $payment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .details-table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 30px;
            text-align: right;
        }

        .summary p {
            margin: 5px 0;
            font-size: 16px;
        }

        .summary .total {
            font-weight: bold;
            font-size: 20px;
            color: #000;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.08);
            z-index: -1000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="watermark">PAID</div>
    <div class="container">
        <div class="header">
            <h1>{{ $hotel->name }}</h1>
            <p>{{ $hotel->address ?? 'N/A' }}, {{ $hotel->city ?? 'N/A' }}, Sri Lanka</p>
            <p>Phone: {{ $hotel->phone_number ?? 'N/A' }} | Email: {{ $hotel->email_address ?? 'N/A' }}</p>
            <hr>
            <h2>PAYMENT RECEIPT</h2>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Billed To:</strong><br>
                    {{ $customer->first_name }} {{ $customer->last_name }}<br>
                    @if ($customer->address_line1)
                        {{ $customer->address_line1 }}, {{ $customer->city }}<br>
                    @endif
                    {{ $customer->contact_email }}<br>
                    {{ $customer->phone_number }}
                </td>
                <td style="width: 50%; text-align: right; vertical-align: top;">
                    <strong>Receipt #:</strong> {{ $payment->id }}<br>
                    <strong>Invoice #:</strong> {{ $bill->bill_number }}<br>
                    <strong>Date Issued:</strong> {{ $receipt_issue_date }}<br>
                    <strong>Payment Date:</strong> {{ $payment->payment_timestamp->format('F j, Y') }}
                </td>
            </tr>
        </table>

        <h3>Payment Details</h3>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Payment Method</th>
                    <th>Transaction Ref.</th>
                    <th>Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment for Invoice #{{ $bill->bill_number }} (Reservation #{{ optional($reservation)->id }})
                    </td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                    <td>LKR {{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 40%; margin-left: 60%; margin-top: 20px;">
            <tr>
                <td><strong>Invoice Total:</strong></td>
                <td style="text-align: right;">LKR {{ number_format($bill->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Amount Paid:</strong></td>
                <td style="text-align: right;">LKR {{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr style="font-weight: bold; border-top: 1px solid #333; border-bottom: 1px solid #333;">
                <td>Balance Due:</td>
                <td style="text-align: right;">LKR {{ number_format($bill->grand_total - $bill->amount_paid, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>

</html>
