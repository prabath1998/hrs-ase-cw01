<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelCompanyRegisterRequest;
use App\Models\TravelCompany;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TravelCompanyController extends Controller
{
    public function showRegistrationForm()
    {
        return view('landing.travel-company.register');
    }

    public function register(TravelCompanyRegisterRequest $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('Travel Company')) {
            $user->assignRole('Travel Company');         }

        if (TravelCompany::where('user_id', auth()->id())->exists()) {
            return redirect()->back()->withErrors(['error' => 'You are already registered as a Travel Partner.']);
        }

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

        return redirect()->route('home')->with('success', 'You are now registered as a Travel Partner!');
    }
}
