<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Exports\ReservationsExport;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Hotel;
use App\Models\OptionalService;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    public function index(Request $request)
{
    $this->checkAuthorization(auth()->user(), ['reservation.manage']);

    $query = Reservation::with([
        'customer',
        'travelCompany',
        'room',
        'roomType',
        'bookedBy',
        'hotel',
        'optionalServices',
    ])->orderBy('created_at', 'desc');

    // Search filter
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->whereHas('customer', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('travelCompany', function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('reference_number', 'like', "%{$search}%");
        });
    }

    if ($request->has('check_in_date') && !empty($request->check_in_date)) {
        $query->whereDate('check_in_date', '>=', $request->check_in_date);
    }

    if ($request->has('check_out_date') && !empty($request->check_out_date)) {
        $query->whereDate('check_out_date', '<=', $request->check_out_date);
    }

    if ($request->has('status') && !empty($request->status)) {
        $query->where('status', $request->status);
    }

    if ($request->has('hotel_id') && !empty($request->hotel_id)) {
        $query->where('hotel_id', $request->hotel_id);
    }

    $reservations = $query->paginate(10);

    return view('backend.pages.reservations.index', [
        'reservations' => $reservations,
        'hotels' => Hotel::pluck('name', 'id'), // For hotel filter dropdown
        'statuses' => [ // For status filter dropdown
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'checked_in' => 'Checked In',
            'checked_out' => 'Checked Out',
            'cancelled' => 'Cancelled',
        ],
    ]);
}

    public function create(Request $request): Renderable
    {
        // dd($request->all());
        $searchParams = $request->validate([
            'hotelId' => 'required|exists:hotels,id',
            'roomTypeId' => 'required|exists:room_types,id',
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::findOrFail($searchParams['hotelId']);
        $roomType = RoomType::findOrFail($searchParams['roomTypeId']);
        $checkIn = Carbon::parse($searchParams['checkIn'])->format('Y-m-d');
        $checkOut = Carbon::parse($searchParams['checkOut'])->format('Y-m-d');

        if ($roomType->hotel_id !== $hotel->id) {
            abort(404, 'Room type not found for this hotel.');
        }

        $optionalServices = OptionalService::where('is_active', true)->get(); // Or filter by hotel if services are hotel-specific
        $discountRate = auth()->user()->travelCompany ? auth()->user()->travelCompany->negotiated_discount_percentage : null;
        return view('pages.reservations.create', compact(
            'hotel',
            'roomType',
            'checkIn',
            'checkOut',
            'optionalServices',
            'discountRate'
        ));
    }

    public function store(Request $request, Hotel $hotel)
    {
        Log::debug(json_decode($request->input('optional_services', [])));
        Log::debug($request->input('optional_services', []));
        Log::debug(gettype($request->input('optional_services', [])));

        $request->merge([
            'optional_services' => array_values(json_decode($request->input('optional_services', []))),
        ]);

        $hasCreditCardGuarantee = $request->input('paymentMethod', false) === 'credit-card';
        $request->merge(['has_credit_card_guarantee' => $hasCreditCardGuarantee]);

        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'amount' => 'numeric|min:1',
            'special_requests' => 'nullable|string',
            'has_credit_card_guarantee' => 'boolean',
            'optional_services' => 'sometimes|array',
            'optional_services.*' => 'exists:optional_services,id',

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $user = Auth::user();

        if ($user->hasRole('Customer')) {
            $reservationUser = $user->customer;
        } elseif ($user->hasRole('Travel Company')) {
            $reservationUser = $user->travelCompany;
        } else {
            $reservationUser = null;
        }

        if (!$reservationUser) {
            return back()->withErrors(['user' => 'You must be logged in as a customer or travel company to make a reservation.'])->withInput();
        }

        $reservationUser->update([
            'payment_info_token' => $validated['has_credit_card_guarantee'] ? Hash::make(Str::random(12)) : null,
            'credit_card_last_four' => $validated['has_credit_card_guarantee'] ? Str::random(4) : null,
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        if ($roomType->hotel_id !== $hotel->id) {
            return back()->withErrors(['room_type_id' => 'Invalid room type for this hotel.'])->withInput();
        }

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $numberOfNights = $checkIn->diffInDays($checkOut);
        $totalEstimatedRoomCharge = $roomType->base_price_per_night * $numberOfNights;
        $suiteBookingPeriod = null;
        $suiteRateApplied = null;

        if ($roomType->is_suite) {
            if ($numberOfNights >= 28 && $roomType->suite_monthly_rate > 0) {
                $totalEstimatedRoomCharge = $roomType->suite_monthly_rate * ceil($numberOfNights / 28);
                $suiteBookingPeriod = 'monthly';
                $suiteRateApplied = $roomType->suite_monthly_rate;
            } else {
                $totalEstimatedRoomCharge = $roomType->suite_weekly_rate * ceil($numberOfNights / 7);
                $suiteBookingPeriod = 'weekly';
                $suiteRateApplied = $roomType->suite_weekly_rate;
            }
        }

        try {
            $reservationData = [
                'hotel_id' => $hotel->id,
                'room_type_id' => $validated['room_type_id'],
                // 'room_id' is NULL until check-in
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status' => $validated['has_credit_card_guarantee'] ? 'confirmed_guaranteed' : 'confirmed_no_cc_hold',
                'has_credit_card_guarantee' => $request->input('has_credit_card_guarantee', false),
                'special_requests' => $validated['special_requests'],
                'booked_by_user_id' => $user->id,
                'total_estimated_room_charge' => $totalEstimatedRoomCharge,
                'is_suite_booking' => $roomType->is_suite,
                'suite_booking_period' => $suiteBookingPeriod,
                'suite_rate_applied' => $suiteRateApplied,
            ];


            if($user->customer) {
                $reservationData['customer_id'] = $reservationUser->id;
            } elseif($user->travelCompany) {
                $reservationData['travel_company_id'] = $reservationUser->id;
            }

            $reservation = Reservation::create($reservationData);

            $subject = 'Reservation Confirmation – ' . $hotel->name;
            $name = $reservation->customer->first_name ?? $reservation->travelCompany->company_name;

            $body = "Hi {$name},

            Your reservation at {$hotel->name} has been confirmed!

            Here are your reservation details:
            - Check-in: " . \Carbon\Carbon::parse($reservation->check_in_date)->format('F j, Y') . "
            - Check-out: " . \Carbon\Carbon::parse($reservation->check_out_date)->format('F j, Y') . "
            - Room Type: {$roomType->name}
            - Estimated Charge: $" . number_format($reservation->total_estimated_room_charge, 2) . "
            " . ($reservation->special_requests ? "- Special Requests: {$reservation->special_requests}" : '') . "

            Thank you for booking with us!";

            sendNotificationEmail($reservationUser->contact_email, $subject, ($body));

            if (!empty($validated['optional_services'])) {
                foreach ($validated['optional_services'] as $serviceId) {
                    $service = OptionalService::find($serviceId);
                    if ($service) {
                        $reservation->optionalServices()->attach($serviceId, [
                            'quantity' => 1,
                            'price_at_booking' => $service->price
                        ]);
                    }
                }
            }
            $this->generateAndGetBill($reservation);
        } catch (\Exception $e) {
            Log::error('Error creating reservation: ' . $e->getMessage());
            return back()->withErrors(['reservation' => 'Failed to create reservation: ' . $e->getMessage()])->withInput();
        }

        $this->storeActionLog(ActionType::CREATED, ['reservation' => $validated]);

        // if ($user->hasRole('customer')) {
        return response()->json(['success' => true, 'message' => 'Reservation created successfully.']);
        // return redirect()->route('dashboard')->with('success', __('Reservation created successfully.'));
        // } else {
        // return redirect()->route('admin.reservations.index')->with('success', __('Reservation created successfully.'));
        // }
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('customer', 'travelCompany', 'hotel', 'roomType', 'room', 'bill', 'optionalServices');

        $availableRooms = Collection::make();
        if (in_array($reservation->status, ['confirmed_guaranteed', 'confirmed_no_cc_hold', 'checked_in'])) {
            $availableRooms = Room::where('hotel_id', $reservation->hotel_id)
                ->where('room_type_id', $reservation->room_type_id)
                ->where('status', 'available')
                ->orWhere('id', $reservation->room_id)
                ->get();
        }

        return view('backend.pages.reservations.show', compact('reservation', 'availableRooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
            'is_suite' => $request->has('is_suite'),
            'suite_weekly_rate' => $request->input('is_suite') ? $request->input('suite_weekly_rate') : null,
            'suite_monthly_rate' => $request->input('is_suite') ? $request->input('suite_monthly_rate') : null,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'occupancy_limit' => 'required|integer|min:1',
            'base_price_per_night' => 'required|numeric|min:0',
            'is_suite' => 'boolean',
            'suite_weekly_rate' => 'nullable|numeric|min:0',
            'suite_monthly_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $reservation->update($validated);
        $this->storeActionLog(ActionType::UPDATED, ['reservation' => $validated['name']]);


        return redirect()->route('admin.room-types.index')->with('success', __('Reservation updated successfully.'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        $this->storeActionLog(ActionType::DELETED, ['reservation' => $reservation->name]);

        return redirect()->route('admin.room-types.index')->with('success', __('Reservation deleted successfully.'));
    }

    public function downloadReceipt(Reservation $reservation)
    {
        try {
            $bill = $reservation->bill;

            // dd($reservation);

            if (!$bill) {
                abort(404, 'Bill not found for this reservation.');
            }

            $bill->load(['customer', 'travelCompany', 'reservation.hotel', 'reservation.roomType', 'payments', 'reservation.optionalServices']);

            $numberOfNights = $bill->reservation ? Carbon::parse($bill->reservation->check_in_date)->diffInDays(Carbon::parse($bill->reservation->check_out_date)) : 0;

            $data = [
                'bill' => $bill,
                'reservation' => $bill->reservation,
                'billedTo' => $bill->customer ?? $bill->travelCompany,
                'numberOfNights' => $numberOfNights,
            ];

            $pdf = Pdf::loadView('layouts.receipts.bill', $data);
            $fileName = 'invoice-' . $bill->bill_number . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Error generating receipt: ' . $e->getMessage());
            abort(404, 'Bill not found for this reservation.');
        }
    }

    public function checkIn(Request $request, Reservation $reservation)
    {
        $request->validate(['room_id' => 'required|exists:rooms,id']);

        $room = Room::where('id', $request->room_id)
            ->where('status', 'available')
            ->where('hotel_id', $reservation->hotel_id)
            ->where('room_type_id', $reservation->room_type_id)
            ->first();

        if (!$room) {
            return back()->with('error', 'The selected room is not available or does not match the reservation type.');
        }

        DB::transaction(function () use ($reservation, $room) {
            $reservation->update([
                'room_id' => $room->id,
                'status' => 'checked_in',
                'actual_check_in_timestamp' => now('Asia/Colombo'),
            ]);
            $room->update(['status' => 'occupied']);
        });

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Guest checked in successfully to Room ' . $room->room_number);
    }

    public function updateRoom(Request $request, Reservation $reservation)
    {
        if ($reservation->status !== 'checked_in') {
            return back()->with('error', 'Cannot change room for a reservation that is not checked-in.');
        }

        $validated = $request->validate(['new_room_id' => 'required|exists:rooms,id']);
        $newRoom = Room::find($validated['new_room_id']);
        $oldRoom = $reservation->room;

        if ($newRoom->id === $oldRoom->id) {
            return back()->with('info', 'The selected room is the same as the current room.');
        }

        if ($newRoom->status !== 'available' || $newRoom->room_type_id !== $reservation->room_type_id) {
            return back()->with('error', 'The new room must be available and of the same type.');
        }

        DB::transaction(function () use ($reservation, $newRoom, $oldRoom) {
            $oldRoom->update(['status' => 'cleaning']);
            $newRoom->update(['status' => 'occupied']);

            $reservation->update(['room_id' => $newRoom->id]);
        });

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Room successfully changed from ' . $oldRoom->room_number . ' to ' . $newRoom->room_number . '.');
    }

    public function checkOut(Reservation $reservation)
    {
        if ($reservation->status !== 'checked_in') {
            return back()->with('error', 'This guest is not currently checked in.');
        }

        DB::transaction(function () use ($reservation) {
            if (!$reservation->bill) {
                $this->generateAndGetBill($reservation);
            }

            $reservation->update([
                'status' => 'checked_out',
                'actual_check_out_timestamp' => now('Asia/Colombo'),
            ]);

            if ($reservation->room) {
                $reservation->room->update(['status' => 'cleaning']);
            }
        });

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Guest checked out successfully from Room ' . $reservation->room->room_number);
    }

    public function cancel(Reservation $reservation)
    {
        if (!in_array($reservation->status, ['confirmed_guaranteed', 'confirmed_no_cc_hold'])) {
            return back()->with('error', 'Only confirmed reservations can be cancelled.');
        }

        $reservation->update(['status' => 'cancelled_by_clerk']);

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Reservation has been successfully cancelled.');
    }

    public function generateBill(Reservation $reservation)
    {
        if ($reservation->bill) {
            return back()->with('info', 'A bill already exists for this reservation.');
        }

        $this->generateAndGetBill($reservation);

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Bill / Folio has been successfully created.');
    }


    private function generateAndGetBill(Reservation $reservation): Bill
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
            'payment_status' => 'pending',
            'generated_by_user_id' => auth()->id(),
        ]);
    }

    public function exportExcel(Request $request)
    {
        $query = Reservation::with(['customer', 'travelCompany', 'hotel', 'roomType', 'room'])
            ->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('customer', function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('travelCompany', function($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%");
                })
                ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('check_in_date') && !empty($request->check_in_date)) {
            $query->whereDate('check_in_date', '>=', $request->check_in_date);
        }

        if ($request->has('check_out_date') && !empty($request->check_out_date)) {
            $query->whereDate('check_out_date', '<=', $request->check_out_date);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('hotel_id') && !empty($request->hotel_id)) {
            $query->where('hotel_id', $request->hotel_id);
        }

        $reservations = $query->get();

        return Excel::download(
            new ReservationsExport($reservations, $request),
            'reservations-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
