<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['dashboard.view']);
        $rooms = Room::with(['roomType', 'hotel'])->paginate(10);
        return view('backend.pages.rooms.index', [
            'rooms' => $rooms,
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['room.manage']);

        $roomTypes = RoomType::all();
        $hotels = Hotel::all();
        $predefinedFeatures = (object) ['has_balcony' => 'Balcony', 'sea_view' => 'Sea View', 'smart_tv' => 'Smart TV'];

        return view('backend.pages.rooms.create', compact('hotels', 'roomTypes', 'predefinedFeatures'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|unique:rooms,room_number',
            'floor' => 'nullable|integer',
            'status' => 'required|string|in:available,occupied,maintenance,blocked',
            'features' => 'nullable|array',
        ]);

        $featuresArray = [];
        $predefinedFeatureKeys = ['has_balcony', 'sea_view', 'smart_tv'];

        if ($request->has('features')) {
            foreach ($predefinedFeatureKeys as $key) {
                $featuresArray[$key] = isset($request->features[$key]);
            }
        } else {
            foreach ($predefinedFeatureKeys as $key) {
                $featuresArray[$key] = false;
            }
        }

        $validated['features'] = $featuresArray;

        Room::create($validated);

        $this->storeActionLog(ActionType::CREATED, ['room' => $validated['room_number']]);

        return redirect()->route('admin.rooms.index')->with('success', __('Room created successfully.'));
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        $hotels = Hotel::all();
        $predefinedFeatures = (object) ['has_balcony' => 'Balcony', 'sea_view' => 'Sea View', 'smart_tv' => 'Smart TV'];

        return view('backend.pages.rooms.edit', compact('room', 'hotels', 'roomTypes', 'predefinedFeatures'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id,
            'floor' => 'nullable|integer',
            'status' => 'required|string|in:available,occupied,maintenance,blocked',
            'features' => 'nullable|array',
        ]);

        $featuresArray = [];
        $predefinedFeatureKeys = ['has_balcony', 'sea_view', 'smart_tv'];

        if ($request->has('features')) {
            foreach ($predefinedFeatureKeys as $key) {
                $featuresArray[$key] = isset($request->features[$key]);
            }
        } else {
            foreach ($predefinedFeatureKeys as $key) {
                $featuresArray[$key] = false;
            }
        }

        $validated['features'] = $featuresArray;

        $room->update($validated);
        $this->storeActionLog(ActionType::UPDATED, ['room' => $validated['room_number']]);


        return redirect()->route('admin.rooms.index')->with('success', __('Room updated successfully.'));
    }

    public function destroy(Room $room)
    {
        $room->delete();

        $this->storeActionLog(ActionType::DELETED, ['room' => $room->room_number]);

        return redirect()->route('admin.rooms.index')->with('success', __('Room deleted successfully.'));
    }
}
