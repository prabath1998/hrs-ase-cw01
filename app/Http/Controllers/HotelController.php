<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Hotel;
use App\Services\HotelService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        private readonly HotelService $hotelService
    ) {}
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

        if($validated['image']) {
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

        if($validated['image']) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
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

        $priceFrom = $hotel->roomTypes->min('price_per_night');
        return view('landing.hotels.detail', compact('hotel', 'priceFrom'));
    }

    public function checkRoomAvailability(Request $request, Hotel $hotel)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        $availability = $this->hotelService->checkRoomAvailability(
            $hotel,
            $request->input('check_in'),
            $request->input('check_out'),
            $request->input('room_type_id')
        );

        return response()->json(['available' => $availability]);
    }
}
