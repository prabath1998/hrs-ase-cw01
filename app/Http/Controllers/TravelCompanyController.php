<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelCompanyRegisterRequest;
use App\Models\TravelCompany;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TravelCompanyController extends Controller
{

    public function index()
    {
        $travelCompanies = TravelCompany::paginate(10);
        return view('backend.pages.travel-companies.index', compact('travelCompanies'));
    }

    public function edit($id)
    {
        $travelCompany = TravelCompany::findOrFail($id);
        return view('backend.pages.travel-companies.edit', compact('travelCompany'));
    }

    public function update(Request $request, $id)
    {
        $travelCompany = TravelCompany::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'required|email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'registration_number' => 'nullable|string|max:255',
            'negotiated_discount_percentage' => 'nullable|numeric|between:0,100',
            'is_approved' => 'required|boolean',
        ]);

        $travelCompany->update($request->all());

        $isApproved = (bool) $request->is_approved;
        $subject = $isApproved
            ? 'Travel Company Approved'
            : 'Travel Company Approval Update';
        $body = $isApproved
            ? 'Congratulations! Your travel company has been approved.'
            : 'We regret to inform you that your travel company request has not been approved. Please contact us for more details.';

        sendNotificationEmail($request->contact_email, $subject, $body);

        return redirect()->route('admin.travel-companies.index')
            ->with('success', 'Travel Company updated successfully.');
    }


    public function destroy($id)
    {
        $travelCompany = TravelCompany::findOrFail($id);
        $travelCompany->delete();

        return redirect()->route('admin.travel-companies.index')->with('success', 'Travel Company deleted successfully.');
    }
    public function showRegistrationForm()
    {
        return view('landing.travel-company.register');
    }

    public function register(TravelCompanyRegisterRequest $request)
    {
        // $user = auth()->user();

        // if (!$user->hasRole('Travel Company')) {
        //     $user->assignRole('Travel Company');
        // }

        // if (TravelCompany::where('user_id', auth()->id())->exists()) {
        //     return redirect()->back()->withErrors(['error' => 'You are already registered as a Travel Partner.']);
        // }

        $user = User::create([
            'name' => $request->input('contact_name'),
            'username' => Str::slug($request->input('contact_name')),
            'email' => $request->input('contact_email'),
            'password' => Hash::make('password'), // Default password
        ]);

        $tr = TravelCompany::create([
            'user_id' => $user->id,
            'company_name' => $request->input('company_name'),
            'contact_name' => $request->input('contact_name'),
            'contact_email' => $request->input('contact_email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'registration_number' => $request->input('registration_number'),
            'negotiated_discount_percentage' => $request->input('negotiated_discount_percentage'),
        ]);

        return redirect()->back()->with('success', 'Travel Company registered successfully. Please wait for approval.');
    }
}
