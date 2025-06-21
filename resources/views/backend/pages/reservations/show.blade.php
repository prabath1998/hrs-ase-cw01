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

                    <div class="w-full">
                        <div class="rounded-xl shadow mb-6 bg-white dark:bg-gray-900">
                            <div
                                class="flex flex-col md:flex-row md:items-center md:justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h6 class="text-lg font-semibold text-primary flex items-center gap-2">
                                    Guest:
                                    {{ $reservation->customer->first_name ?? $reservation->travel_company->company_name }}
                                </h6>
                                <span
                                    class="inline-block rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 text-xs font-semibold">
                                    {{ ucwords(str_replace('_', ' ', $reservation->status)) }}
                                </span>
                            </div>
                            <div class="px-6 py-5">
                                <!-- Reservation Info -->
                                <p class="mb-2"><strong>Hotel:</strong> {{ $reservation->hotel->name }}</p>
                                <p class="mb-2"><strong>Dates:</strong>
                                    {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }} to
                                    {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</p>
                                <p class="mb-2"><strong>Room Type:</strong> {{ $reservation->roomType->name }}</p>
                                <p class="mb-2"><strong>Assigned Room:</strong>
                                    {{ $reservation->room->room_number ?? 'Not yet assigned' }}</p>

                                <hr class="my-4 border-gray-200 dark:border-gray-700">

                                <!-- Action Buttons -->
                                <div class="mt-3 flex flex-wrap gap-3">
                                    @if (in_array($reservation->status, ['pending_payment', 'confirmed_guaranteed', 'confirmed_no_cc_hold']))
                                        <button
                                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded transition"
                                            x-data x-on:click="$dispatch('open-modal', { id: 'checkInModal' })">
                                            <i class="fas fa-sign-in-alt"></i> Perform Check-in
                                        </button>
                                    @endif

                                    @if ($reservation->status === 'checked_in')
                                        <button
                                            class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded transition"
                                            x-data x-on:click="$dispatch('open-modal', { id: 'addChargeModal' })">
                                            <i class="fas fa-plus"></i> Add Charge / Bill Item
                                        </button>
                                        <button
                                            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded transition"
                                            x-data x-on:click="$dispatch('open-modal', { id: 'checkOutModal' })">
                                            <i class="fas fa-sign-out-alt"></i> Generate Bill & Check-out
                                        </button>
                                    @endif

                                    @if ($reservation->bill)
                                        <a href="{{ route('bills.receipt.show', $reservation->bill) }}"
                                            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded transition"
                                            target="_blank">
                                            <i class="fas fa-receipt"></i> View Bill / Folio
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Check-in Modal (Alpine.js + Tailwind CSS) -->
        <div
            x-data="{ open: false }"
            x-on:open-modal.window="if ($event.detail.id === 'checkInModal') open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            aria-modal="true"
            role="dialog"
        >
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg w-full max-w-md mx-auto">
                <form action="{{ route('admin.reservations.checkin', $reservation) }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h5 class="text-lg font-semibold">Check-in Guest & Assign Room</h5>
                        <button type="button" x-on:click="open = false" class="text-gray-400 hover:text-gray-700 dark:hover:text-white text-2xl">&times;</button>
                    </div>
                    <div class="px-6 py-4">
                        <p class="mb-4">Select an available room of type '{{ $reservation->roomType->name }}' to assign.</p>
                        @if ($availableRooms->isEmpty())
                            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-2">No available rooms of this type found!</div>
                        @else
                            <div class="mb-4">
                                <label for="room_id" class="block mb-1 font-medium">Available Rooms</label>
                                <select name="room_id" id="room_id" class="w-full border border-gray-300 dark:border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400 dark:bg-gray-800 dark:text-white" required>
                                    <option value="">-- Please select a room --</option>
                                    @foreach ($availableRooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" x-on:click="open = false" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 disabled:opacity-50"
                            @if ($availableRooms->isEmpty()) disabled @endif>Confirm Check-in</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Check-out Modal (Alpine.js + Tailwind CSS) -->
        <div
            x-data="{ open: false }"
            x-on:open-modal.window="if ($event.detail.id === 'checkOutModal') open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            aria-modal="true"
            role="dialog"
        >
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg w-full max-w-md mx-auto">
                <form action="{{ route('admin.reservations.checkout', $reservation) }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h5 class="text-lg font-semibold">Confirm Check-out</h5>
                        <button type="button" x-on:click="open = false" class="text-gray-400 hover:text-gray-700 dark:hover:text-white text-2xl">&times;</button>
                    </div>
                    <div class="px-6 py-4">
                        <p class="mb-2">This will perform the following actions:</p>
                        <ul class="list-disc list-inside mb-4 text-sm text-gray-700 dark:text-gray-200">
                            <li>Generate the final bill if it doesn't exist.</li>
                            <li>Mark the reservation as 'checked_out'.</li>
                            <li>Update the room status to 'cleaning'.</li>
                        </ul>
                        <p class="font-semibold text-red-600 dark:text-red-400">Are you sure you want to proceed?</p>
                    </div>
                    <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" x-on:click="open = false" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Confirm & Check-out</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Charge Modal (Alpine.js + Tailwind CSS, Example Structure) -->
        <div
            x-data="{ open: false }"
            x-on:open-modal.window="if ($event.detail.id === 'addChargeModal') open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            aria-modal="true"
            role="dialog"
        >
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg w-full max-w-md mx-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h5 class="text-lg font-semibold">Add Charge / Bill Item</h5>
                    <button type="button" x-on:click="open = false" class="text-gray-400 hover:text-gray-700 dark:hover:text-white text-2xl">&times;</button>
                </div>
                <div class="px-6 py-4">
                    <!-- Form to add a new BillItem would go here -->
                    <p class="text-gray-500 dark:text-gray-300">Form to add a new BillItem would go here.</p>
                </div>
                <div class="flex justify-end px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" x-on:click="open = false" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
