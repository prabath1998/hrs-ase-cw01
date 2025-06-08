<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Customer;
use App\Models\Hotel;
use App\Models\OptionalService;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['reservation.manage']);
        $reservations = Reservation::with([
            'customer',
            'travelCompany',
            'room',
            'roomType',
            'bookedBy',
            'hotel',
            'optionalServices',

        ])->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.pages.reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    public function create(Request $request): Renderable
    {
        // dd($request->all());
        // Validate incoming search parameters (dates, guests) from the query string
        $searchParams = $request->validate([
            'hotelId' => 'required|exists:hotels,id',
            'roomTypeId' => 'required|exists:room_types,id',
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::findOrFail($searchParams['hotelId']);
        $roomType = RoomType::findOrFail($searchParams['roomTypeId']);

        if ($roomType->hotel_id !== $hotel->id) {
            abort(404, 'Room type not found for this hotel.');
        }

        // $checkIn = Carbon::parse($searchParams['check_in_date']);
        // $checkOut = Carbon::parse($searchParams['check_out_date']);
        // $numberOfNights = $checkIn->diffInDays($checkOut);

        // $estimatedRoomPrice = $roomType->base_price_per_night * $numberOfNights;
        // $appliedRateType = 'Nightly';

        // if ($roomType->is_suite) {
        //     if ($numberOfNights >= 28 && $roomType->suite_monthly_rate > 0) {
        //         $estimatedRoomPrice = $roomType->suite_monthly_rate * ceil($numberOfNights / 28);
        //         $appliedRateType = 'Monthly';
        //     } elseif ($numberOfNights >= 7 && $roomType->suite_weekly_rate > 0) {
        //         $estimatedRoomPrice = $roomType->suite_weekly_rate * ceil($numberOfNights / 7);
        //         $appliedRateType = 'Weekly';
        //     }
        // }

        $optionalServices = OptionalService::where('is_active', true)->get(); // Or filter by hotel if services are hotel-specific

        return view('pages.reservations.create', compact(
            'hotel',
            'roomType',
            // 'searchParams',
            // 'estimatedRoomPrice',
            // 'numberOfNights',
            'optionalServices',
            // 'appliedRateType'
        ));
    }

    public function store(Request $request, Hotel $hotel)
    {
        // dd($hotel, $request->all());
        Log::debug(json_decode($request->input('optional_services', [])));
        Log::debug($request->input('optional_services', []));
        Log::debug(gettype($request->input('optional_services', [])));

        $request->merge([
            'optional_services' => array_values(json_decode($request->input('optional_services', []))),
            'has_credit_card_guarantee' => (bool)$request->input('has_credit_card_guarantee'),
            // 'nic_or_passport_number' => $request->input('nic_or_passport_number', null),
        ]);


        Log::debug($request->all());
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'amount' => 'numeric|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            // 'nic_or_passport_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'special_requests' => 'nullable|string',
            'has_credit_card_guarantee' => 'sometimes|boolean',
            'optional_services' => 'sometimes|array',
            'optional_services.*' => 'exists:optional_services,id',

        ]);

        if ($validator->fails()) {
            Log::debug(100);
            Log::debug($validator->errors()->all());
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        Log::debug(110);
        Log::debug($validated);

        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'username' => strtolower($validated['first_name']) . '_' . strtolower($validated['last_name']),
                'email' => $validated['contact_email'],
                'password' => Hash::make(Str::random(8)),
            ]);
            $user->assignRole('customer');
        }

        $customer = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_email' => $validated['contact_email'],
                'phone_number' => $validated['phone_number'],
                // 'nic_or_passport_number' => $validated['nic_or_passport_number'],
                'address' => $validated['address'],
                'payment_info_token' => $validated['has_credit_card_guarantee'] ? Hash::make(Str::random(12)) : null,
                'credit_card_last_four' => $validated['has_credit_card_guarantee'] ? Str::random(4) : null,
            ]
        );

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        if ($roomType->hotel_id !== $hotel->id) {
            return back()->withErrors(['room_type_id' => 'Invalid room type for this hotel.'])->withInput();
        }

        // Recalculate price on backend to ensure integrity
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
            } elseif ($numberOfNights >= 7 && $roomType->suite_weekly_rate > 0) {
                $totalEstimatedRoomCharge = $roomType->suite_weekly_rate * ceil($numberOfNights / 7);
                $suiteBookingPeriod = 'weekly';
                $suiteRateApplied = $roomType->suite_weekly_rate;
            }
        }
        Log::debug(160);

        try {
            $reservation = Reservation::create([
                'customer_id' => $customer->id,
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
            ]);

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

            // Send confirmation email to customer
        } catch (\Exception $e) {
            return back()->withErrors(['reservation' => 'Failed to create reservation: ' . $e->getMessage()])->withInput();
        }

        $this->storeActionLog(ActionType::CREATED, ['reservation' => $validated]);
        // dd('Reservation created successfully', $reservation);

        if ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard')->with('success', __('Reservation created successfully.'));
        } else {
            return redirect()->route('admin.reservations.index')->with('success', __('Reservation created successfully.'));
        }
    }

    public function edit(RoomType $roomType)
    {
        return view('backend.pages.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
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

        $roomType->update($validated);
        $this->storeActionLog(ActionType::UPDATED, ['room_type' => $validated['name']]);


        return redirect()->route('admin.room-types.index')->with('success', __('Room type updated successfully.'));
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        $this->storeActionLog(ActionType::DELETED, ['room_type' => $roomType->name]);

        return redirect()->route('admin.room-types.index')->with('success', __('Room type deleted successfully.'));
    }
}
