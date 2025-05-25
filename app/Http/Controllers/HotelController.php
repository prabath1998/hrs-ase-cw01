<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Services\RolesService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RolesService $rolesService
    ) {
    }
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
}
