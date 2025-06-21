@extends('backend.layouts.app')

@section('title')
    {{ __('Reservation Details') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Reservation Details') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Reservation Details:
                    #{{ $reservation->id }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.room-types.index') }}">
                                {{ __('Room Types') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('New Room Type') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                {{-- <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Create New Room Type') }}</h3>
                </div> --}}
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <div class="lg:col-span-2">
                            <!-- Guest Information Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
                                <div class="p-4 border-b dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Guest Information</h3>
                                </div>
                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Booked For</span>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $reservation->customer ? $reservation->customer->first_name . ' ' . $reservation->customer->last_name : $reservation->travelCompany->company_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Contact Email</span>
                                        <p class="text-gray-800 dark:text-gray-200">
                                            {{ $reservation->customer ? $reservation->customer->contact_email : $reservation->travelCompany->contact_email }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Contact Phone</span>
                                        <p class="text-gray-800 dark:text-gray-200">
                                            {{ $reservation->customer ? $reservation->customer->phone_number : $reservation->travelCompany->contact_phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
                                <div class="p-4 border-b dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Booking Details</h3>
                                </div>
                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Hotel</span>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $reservation->hotel->name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Room Type</span>
                                        <p class="text-gray-800 dark:text-gray-200">{{ $reservation->roomType->name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Check-in / Check-out</span>
                                        <p class="text-gray-800 dark:text-gray-200">
                                            {{ $reservation->check_in_date->format('M d, Y') }} &rarr;
                                            {{ $reservation->check_out_date->format('M d, Y') }}
                                            <span
                                                class="text-xs text-gray-500">({{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }}
                                                Nights)</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Assigned Room</span>
                                        <p class="font-bold text-lg text-blue-600 dark:text-blue-400">
                                            {{ $reservation->room->room_number ?? 'Not Assigned' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Manage Booking</h3>
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full {{ $reservation->statusColor() }}">
                                        {{ $reservation->statusLabel() }}
                                    </span>
                                </div>
                                <div class="p-4 space-y-3">

                                    <!-- Check-in Action -->
                                    @if (in_array($reservation->status, ['confirmed_guaranteed', 'confirmed_no_cc_hold']))
                                        <button data-modal-target="checkin-modal" data-modal-toggle="checkin-modal"
                                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600">
                                            Perform Check-in
                                        </button>
                                    @endif

                                    <!-- Change Room Action -->
                                    @if ($reservation->status === 'checked_in')
                                        <button data-modal-target="change-room-modal" data-modal-toggle="change-room-modal"
                                            class="w-full text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Change Assigned Room
                                        </button>
                                    @endif

                                    <!-- Create Bill Action -->
                                    @if ($reservation->status === 'checked_in' && !$reservation->bill)
                                        <form action="{{ route('admin.reservations.generateBill', $reservation->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Create Bill / Folio
                                            </button>
                                        </form>
                                    @endif

                                    <!-- View Bill Action -->
                                    @if ($reservation->bill)
                                        <a href="{{ route('bills.receipt.show', $reservation->bill->id) }}" target="_blank"
                                            class="w-full block text-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                            View Bill / Folio
                                        </a>
                                    @endif

                                    <!-- Check-out Action -->
                                    @if ($reservation->status === 'checked_in')
                                        <form action="{{ route('admin.reservations.checkout', $reservation->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Perform Check-out
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Cancel Reservation Action -->
                                    @if (in_array($reservation->status, ['confirmed_guaranteed', 'confirmed_no_cc_hold']))
                                        <button data-modal-target="cancel-modal" data-modal-toggle="cancel-modal"
                                            class="w-full text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                            Cancel Reservation
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Check-in Modal -->
    <div id="checkin-modal" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center ...">
        <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700">
            <form action="{{ route('admin.reservations.checkin', $reservation->id) }}" method="POST">
                @csrf
                <div class="p-4 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Check-in & Assign Room</h3>
                    <p class="text-sm text-gray-500 mb-4">Select an available room of type
                        '{{ $reservation->roomType->name }}' to assign to this reservation.</p>
                    @if ($availableRooms->isEmpty())
                        <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <span class="font-medium">No rooms available!</span> There are no available rooms of this type.
                            Please check inventory.
                        </div>
                    @else
                        <div class="mb-4">
                            <label for="room_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Available Rooms</label>
                            <select name="room_id" id="room_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ..."
                                required>
                                <option value="" selected>-- Please select a room --</option>
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        {{ $availableRooms->isEmpty() ? 'disabled' : '' }}>Confirm Check-in</button>
                    <button data-modal-hide="checkin-modal" type="button" class="py-2.5 px-5 ms-3 ...">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Reservation Modal -->
    <div id="cancel-modal" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center ...">
        <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700">
            <form action="{{ route('admin.reservations.cancel', $reservation->id) }}" method="POST">
                @csrf
                @method('PATCH') <!-- Use PATCH for status updates -->
                <div class="p-4 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to cancel
                        this reservation?</h3>
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 ...">Yes, Cancel It</button>
                    <button data-modal-hide="cancel-modal" type="button" class="py-2.5 px-5 ms-3 ...">No, keep
                        it</button>
                </div>
            </form>
        </div>
    </div>
@endsection
