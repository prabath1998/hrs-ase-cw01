<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Hotel;
use App\Services\RolesService;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RolesService $rolesService
    ) {}
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['dashboard.view']);
        $hotels = Hotel::paginate(10);
        return view('backend.pages.hotels.index', [
            'users' => $this->userService->getUsers(),
            'roles' => $this->rolesService->getRolesDropdown(),
            'hotels' => $hotels,
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        ld_do_action('user_create_page_before');

        return view('backend.pages.hotels.create', [
            'roles' => $this->rolesService->getRolesDropdown(),
        ]);
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
            'default_check_out_time' => 'required|date|after_or_equal:default_check_in_time',
            'is_active' => 'nullable|boolean',
        ]);

        Hotel::create($validated);

        $this->storeActionLog(ActionType::CREATED, ['hotel' => $validated['name']]);

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
            'default_check_out_time' => 'required|date|after_or_equal:default_check_in_time',
            'is_active' => 'boolean',
        ]);

        $hotel->update($validated);
        $this->storeActionLog(ActionType::UPDATED, ['hotel' => $validated['name']]);


        return redirect()->route('admin.hotels.index')->with('success', __('Hotel updated successfully.'));
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        $this->storeActionLog(ActionType::DELETED, ['hotel' => $hotel]);

        return redirect()->route('admin.hotels.index')->with('success', __('Hotel deleted successfully.'));
    }
}
