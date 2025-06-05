<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['dashboard.view']);
        $roomTypes = RoomType::with('hotel')->paginate(10);
        return view('backend.pages.room-types.index', [
            'roomTypes' => $roomTypes,
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['room_type.manage']);

        $hotels = Hotel::get(['id', 'name']);

        return view('backend.pages.room-types.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
            'is_suite' => $request->has('is_suite'),
            'suite_weekly_rate' => $request->input('is_suite') ? $request->input('suite_weekly_rate') : null,
            'suite_monthly_rate' => $request->input('is_suite') ? $request->input('suite_monthly_rate') : null,
        ]);

        $validated = $request->validate([
            'hotel_id' => 'exists:hotels,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'occupancy_limit' => 'required|integer|min:1',
            'base_price_per_night' => 'required|numeric|min:0',
            'is_suite' => 'boolean',
            'suite_weekly_rate' => 'nullable|numeric|min:0',
            'suite_monthly_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        RoomType::create($validated);

        $this->storeActionLog(ActionType::CREATED, ['room_type' => $validated]);

        return redirect()->route('admin.room-types.index')->with('success', __('Room type created successfully.'));
    }

    public function edit(RoomType $roomType)
    {
        $hotels = Hotel::get(['id', 'name']);
        return view('backend.pages.room-types.edit', compact('roomType', 'hotels'));
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
            'hotel_id' => 'exists:hotels,id',
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
