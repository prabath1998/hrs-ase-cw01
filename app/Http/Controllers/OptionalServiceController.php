<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\OptionalService as OptionalServiceModel;
use App\Services\OptionalService;
use Illuminate\Http\Request;

class OptionalServiceController extends Controller
{
    public function __construct(
        private readonly OptionalService $optionalService
    ) {}
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['dashboard.view']);

        return view('backend.pages.optional-services.index', ['services' => $this->optionalService->getOptionalServices()]);
    }

    public function create()
    {
        return view('backend.pages.optional-services.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:optional_services,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        OptionalServiceModel::create($validated);

        $this->storeActionLog(ActionType::CREATED, ['optional-service' => $validated]);

        return redirect()->route('admin.optional-services.index')->with('success', __('Optional service created successfully.'));
    }

    public function edit(OptionalServiceModel $optional_service)
    {
        return view('backend.pages.optional-services.edit', compact('optional_service'));
    }

    public function update(Request $request, OptionalServiceModel $optional_service)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:optional_services,name,' . $optional_service->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $optional_service->update($validated);

        $this->storeActionLog(ActionType::UPDATED, ['optional-service' => $validated]);

        return redirect()->route('admin.optional-services.index')->with('success', __('Optional service updated successfully.'));
    }

    public function destroy(OptionalServiceModel $optional_service)
    {
        $optional_service->delete();
        $this->storeActionLog(ActionType::DELETED, ['optional-service' => $optional_service]);
        return redirect()->route('admin.optional-services.index')->with('success', __('Optional service deleted successfully.'));
    }
}
