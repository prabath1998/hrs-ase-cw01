<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\OptionalService;
use App\Services\HotelService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        private readonly HotelService $hotelService
    ) {
    }
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['dashboard.view']);

        return view('backend.pages.hotels.index', [
            'hotels' => $this->hotelService->getHotels(),
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        return view('backend.pages.hotels.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|unique:hotels,contact_email',
            'phone_number' => 'nullable|string|max:20',
            'default_check_in_time' => 'required|date',
            'default_check_out_time' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        Hotel::create($validated);

        $this->storeActionLog(ActionType::CREATED, ['hotel' => $validated]);

        return redirect()->route('admin.hotels.index')->with('success', __('Hotel created successfully.'));
    }


    public function edit(Hotel $hotel)
    {
        return view('backend.pages.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|unique:hotels,contact_email,' . $hotel->id,
            'phone_number' => 'nullable|string|max:20',
            'default_check_in_time' => 'required|date',
            'default_check_out_time' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        } else {
            unset($validated['image']);
        }

        $hotel->update($validated);

        $this->storeActionLog(ActionType::UPDATED, ['hotel' => $validated]);

        return redirect()->route('admin.hotels.index')->with('success', __('Hotel updated successfully.'));
    }


    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        $this->storeActionLog(ActionType::DELETED, ['hotel' => $hotel]);

        return redirect()->route('admin.hotels.index')->with('success', __('Hotel deleted successfully.'));
    }

    public function showAllHotels()
    {
        $hotels = $this->hotelService->getHotels();

        return view('landing.hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        $hotel = Hotel::with(['roomTypes'])
            ->where('id', $hotel->id)
            ->firstOrFail();

        $priceFrom = $hotel->roomTypes->min('base_price_per_night');
        $hotel->features = $hotel->roomTypes->pluck('features')->flatten()->unique()->values();
        $hotel->default_check_in_time = $hotel->default_check_in_time->format('H:i');
        $hotel->default_check_out_time = $hotel->default_check_out_time->format('H:i');
        $optionalServices = OptionalService::where('is_active', true)->get('name')->pluck('name')->values();
        $hotel->images = json_decode($hotel->images, true) ?? [];

        $hotel->roomTypes = $hotel->roomTypes->map(function ($room) use ($hotel) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'description' => $room->description,
                'images' => $hotel->images[array_rand($hotel->images)],
                'price' => $room->base_price_per_night,
                'originalPrice' => $room->base_price_per_night ?? null,
                'size' => $room->size ?? '',
                'maxGuests' => $room->occupancy_limit ?? 2,
                'bedType' => $room->bed_type ?? '',
                'views' => $room->views ?? [],
                'amenities' => $room->amenities ?? [],
                'popularChoice' => $room->popular_choice ?? false,
                'lastBooked' => $room->last_booked ?? null,
            ];
        });

        return view('landing.hotels.detail', compact('hotel', 'priceFrom', 'optionalServices'));
    }

    public function checkRoomAvailability(Request $request, Hotel $hotel)
    {

        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        $roomType = RoomType::findOrFail($request->input('room_type_id'));
        if (!$roomType->is_active) {
            return response()->json(['available' => false, 'message' => __('Room type is not available.')], 400);
        }

        $availableCount = $this->hotelService->getAvailableRoomCount(
            $hotel,
            $request->input('check_in'),
            $request->input('check_out'),
            $roomType
        );
        info($availableCount);

        return response()->json(['available' => $availableCount]);
    }
}
