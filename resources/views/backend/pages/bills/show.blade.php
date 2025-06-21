@extends('backend.layouts.app')

@section('title', 'Invoice #' . $bill->bill_number)

@push('styles')
    {{-- Add print-specific styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush
@section('admin-content')

    <div class="container-fluid mx-auto p-4">

        <!-- Action Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 no-print">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Invoice #{{ $bill->bill_number }}</h1>
                <p class="text-sm text-gray-500">
                    For Reservation #{{ $reservation->id ?? 'N/A' }}
                </p>
            </div>
            <div>
                <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase hover:bg-gray-300">
                    Back to Reservation
                </a>
                <button onclick="window.print()"
                    class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>

        <!-- Printable Receipt Area -->
        <div id="print-section" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 md:p-10">
            <!-- Header -->
            @if (optional($reservation)->hotel)
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $reservation->hotel->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $reservation->hotel->address }},
                        {{ $reservation->hotel->city }}</p>
                    <p class="text-gray-600 dark:text-gray-400">Phone: {{ $reservation->hotel->phone_number }} | Email:
                        {{ $reservation->hotel->email_address }}</p>
                </div>
            @endif

            <div class="flex justify-between items-start mb-8 pb-4 border-b dark:border-gray-700">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Invoice To:</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        @if ($billedTo instanceof \App\Models\Customer)
                            {{ $billedTo->first_name }} {{ $billedTo->last_name }}
                        @else
                            {{ $billedTo->company_name }}
                        @endif
                    </p>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ optional($billedTo)->contact_email ?? optional($billedTo)->email }}</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ optional($billedTo)->contact_phone ?? optional($billedTo)->phone_number }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold uppercase text-gray-800 dark:text-white">Invoice</h2>
                    <p class="text-gray-600 dark:text-gray-400">#{{ $bill->bill_number }}</p>
                    <p class="mt-2 text-sm text-gray-500">Date Issued:</p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($bill->bill_date)->format('F j, Y') }}</p>
                </div>
            </div>

            <!-- Reservation Summary -->
            @if ($reservation)
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-white mb-2">Reservation Summary</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Check-in:</span>
                            <strong
                                class="block text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500">Check-out:</span>
                            <strong
                                class="block text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500">Room Type:</span>
                            <strong
                                class="block text-gray-800 dark:text-gray-200">{{ $reservation->roomType->name }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500">Room No:</span>
                            <strong
                                class="block text-gray-800 dark:text-gray-200">{{ $reservation->room->room_number ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Charges Table -->
            <table class="w-full text-left">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="p-3 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase">Date</th>
                        <th class="p-3 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase">Description</th>
                        <th class="p-3 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase text-right">Amount
                            (LKR)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Room Charges -->
                    @if ($reservation)
                        <tr class="border-b dark:border-gray-700">
                            <td class="p-3">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d') }}
                            </td>
                            <td class="p-3">
                                Room Charge ({{ $numberOfNights }} {{ Str::plural('Night', $numberOfNights) }})
                                @if ($reservation->is_suite_booking)
                                    <span class="text-xs text-gray-500 block"> -
                                        {{ ucwords($reservation->suite_booking_period) }} Rate Applied</span>
                                @endif
                            </td>
                            <td class="p-3 text-right">{{ number_format($bill->subtotal_room_charges, 2) }}</td>
                        </tr>
                    @endif

                    <!-- Pre-booked Optional Services -->
                    @if (optional($reservation)->optionalServices->isNotEmpty())
                        @foreach ($reservation->optionalServices as $service)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d') }}</td>
                                <td class="p-3">{{ $service->name }} (x{{ $service->pivot->quantity }}) <span
                                        class="text-xs text-gray-500">- Pre-booked</span></td>
                                <td class="p-3 text-right">
                                    {{ number_format($service->pivot->price_at_booking * $service->pivot->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    <!-- Ad-hoc Bill Items -->
                    {{-- @foreach ($bill->billItems as $item)
                        <tr class="border-b dark:border-gray-700">
                            <td class="p-3">{{ \Carbon\Carbon::parse($item->charge_date)->format('Y-m-d') }}</td>
                            <td class="p-3">{{ $item->description }} (x{{ $item->quantity }})</td>
                            <td class="p-3 text-right">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>

            <!-- Summary Section -->
            <div class="flex justify-end mt-6">
                <div class="w-full md:w-1/2 lg:w-2/5">
                    <div class="flex justify-between py-2 border-b dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                        <span class="text-gray-800 dark:text-gray-200">LKR
                            {{ number_format($bill->subtotal_room_charges + $bill->subtotal_optional_services, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Discount:</span>
                        <span class="text-green-600">- LKR {{ number_format($bill->discount_amount_applied, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Tax
                            ({{ (float) $bill->tax_percentage_applied }}%):</span>
                        <span class="text-gray-800 dark:text-gray-200">LKR {{ number_format($bill->tax_amount, 2) }}</span>
                    </div>
                    <div
                        class="flex justify-between py-2 font-bold border-b-2 border-t-2 border-gray-800 dark:border-gray-300 mt-2">
                        <span class="text-gray-900 dark:text-white text-lg">Grand Total:</span>
                        <span class="text-gray-900 dark:text-white text-lg">LKR
                            {{ number_format($bill->grand_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Payments Received:</span>
                        <span class="text-gray-800 dark:text-gray-200">- LKR
                            {{ number_format($bill->amount_paid, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 font-bold bg-gray-100 dark:bg-gray-700 rounded-lg mt-2 px-2">
                        <span class="text-gray-900 dark:text-white text-lg">Balance Due:</span>
                        <span class="text-gray-900 dark:text-white text-lg">LKR
                            {{ number_format($bill->grand_total - $bill->amount_paid, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-sm text-gray-500 mt-12 pt-4 border-t dark:border-gray-700">
                <p>Thank you for staying with us!</p>
                <p>{{ optional($reservation)->hotel->name }} | Invoice Generated:
                    {{ now('Asia/Colombo')->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>
@endsection
