<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Partner Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<x-header />

<body class="bg-gradient-to-br from-sky-50 to-indigo-50 min-h-screen">
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Become a Travel Partner</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Expand your business reach by partnering with us. Fill out the form below to get started!
                </p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-6 px-8">
                    <h3 class="text-white text-xl font-semibold">Partner Registration Form</h3>
                </div>

                @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


                <form action="{{ route('travel-company.register.submit') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="company_name">
                                Company Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="company_name" id="company_name" required
                                value="{{ old('company_name') }}"
                                class="h-12 w-full border @error('company_name') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                            @error('company_name')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_name">
                                Contact Person
                            </label>
                            <input type="text" name="contact_name" id="contact_name"
                                value="{{ old('contact_name') }}"
                                class="h-12 w-full border @error('contact_name') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                            @error('contact_name')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_email">
                                Contact Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="contact_email" id="contact_email" required
                                value="{{ old('contact_email') }}"
                                class="h-12 w-full border @error('contact_email') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                            @error('contact_email')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="phone_number">
                                Phone Number
                            </label>
                            <input type="tel" name="phone_number" id="phone_number"
                                value="{{ old('phone_number') }}"
                                class="h-12 w-full border @error('phone_number') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                            @error('phone_number')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registration Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="registration_number">
                                Company Registration No
                            </label>
                            <input type="text" name="registration_number" id="registration_number"
                                value="{{ old('registration_number') }}"
                                class="h-12 w-full border @error('registration_number') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                            @error('registration_number')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="address">
                                Company Address
                            </label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full border @error('address') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 py-3 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Negotiated Discount Percentage -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="negotiated_discount_percentage">
                                Negotiated Discount (%)
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" name="negotiated_discount_percentage" id="negotiated_discount_percentage"
                                    value="{{ old('negotiated_discount_percentage') }}"
                                    class="h-12 w-full border @error('negotiated_discount_percentage') border-rose-500 @else border-gray-300 @enderror rounded-lg pl-4 pr-10 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500">%</span>
                                </div>
                            </div>
                            @error('negotiated_discount_percentage')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Type -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="company_type">
                                Company Type
                            </label>
                            <select name="company_type" id="company_type"
                                class="h-12 w-full border @error('company_type') border-rose-500 @else border-gray-300 @enderror rounded-lg px-4 text-sm transition-colors focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
                                <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>Select company type</option>
                                <option value="hotel" {{ old('company_type') == 'hotel' ? 'selected' : '' }}>Hotel/Accommodation</option>
                                <option value="airline" {{ old('company_type') == 'airline' ? 'selected' : '' }}>Airline</option>
                                <option value="tour" {{ old('company_type') == 'tour' ? 'selected' : '' }}>Tour Operator</option>
                                <option value="transport" {{ old('company_type') == 'transport' ? 'selected' : '' }}>Transportation</option>
                                <option value="other" {{ old('company_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('company_type')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">
                                    I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                        @error('terms')
                            <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 text-center">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium text-lg rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Register Company
                        </button>
                    </div>
                </form>

            </div>

            <!-- Additional Information -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Grow Your Business</h3>
                    <p class="text-gray-600">Access our network of travelers and increase your bookings.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Easy Management</h3>
                    <p class="text-gray-600">Manage your listings and bookings through our partner dashboard.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Flexible Payments</h3>
                    <p class="text-gray-600">Receive payments quickly with our secure payment processing system.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
