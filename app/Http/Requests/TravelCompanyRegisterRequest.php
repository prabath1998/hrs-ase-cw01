<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelCompanyRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255|unique:travel_companies,company_name',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'required|email|unique:travel_companies,contact_email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'registration_number' => 'nullable|string|max:255',
            'negotiated_discount_percentage' => 'nullable|numeric|between:0,100',
        ];
    }
}

