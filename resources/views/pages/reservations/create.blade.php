@extends('layouts.guest')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="reservationForm()">
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row gap-10 mb-4">
                    <!-- Reservation Form -->
                    <div class="lg:w-7/12">
                        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                            <div class="px-8 py-6 border-b">
                                <h1 class="text-2xl font-bold text-gray-900">Complete Your Reservation</h1>
                                <p class="text-gray-500 mt-1">Please fill in the details to confirm your booking</p>
                            </div>

                            <!-- Progress Bar -->
                            <div class="relative h-1 bg-gray-100">
                                <div class="form-progress-bar absolute top-0 left-0 bg-gradient-to-tr from-blue-600 via-purple-600 to-indigo-600"
                                    :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                            </div>

                            <!-- Form Steps -->
                            <form @submit.prevent="submitForm" class="px-8 py-6">
                                <!-- Step 1: Room Selection -->
                                <div x-show="currentStep === 1" x-cloak>
                                    <h2 class="text-xl font-semibold mb-5 text-gray-800">Room Selection</h2>
                                    <div class="border rounded-lg overflow-hidden mb-7 bg-gray-50">
                                        <div class="flex flex-col md:flex-row">
                                            <div class="md:w-1/3">
                                                <img src="{{ json_decode($hotel->images)[1] }}"
                                                    alt="Deluxe Room" class="w-full h-full object-cover aspect-square">
                                            </div>
                                            <div class="p-5 md:w-2/3">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h3 class="text-lg font-semibold">{{ $roomType->name }}</h3>
                                                        <p class="text-gray-500 text-xs mt-1">1 King Bed • City View • 45m²
                                                        </p>
                                                        <div class="mt-2 flex items-center">
                                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                </path>
                                                            </svg>
                                                            <span class="ml-1 text-gray-500 text-xs">4.8 (120
                                                                reviews)</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-2xl font-bold text-blue-600">$<span
                                                                x-model="roomBasePrice" x-text="roomBasePrice"></span></p>
                                                        <p class="text-gray-400 text-xs">per night</p>
                                                        @if (isset($appliedRateType) && $appliedRateType !== 'Nightly')
                                                            <small class="text-muted fw-normal">({{ $appliedRateType }}
                                                                Rate)</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <h4 class="font-medium text-gray-800 text-sm">Room Amenities:</h4>
                                                    <ul class="mt-2 grid grid-cols-2 gap-x-4 gap-y-2 text-xs">
                                                        @foreach ($roomType->features ?? [] as $feature)
                                                            <li class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor"
                                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                {{ $feature }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label for="checkInDate"
                                                class="block text-xs font-medium text-gray-700 mb-1">Check-in Date</label>
                                            <input type="text" id="checkInDate"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Select date" x-model="check_in_date" required>
                                        </div>
                                        <div>
                                            <label for="checkOutDate"
                                                class="block text-xs font-medium text-gray-700 mb-1">Check-out Date</label>
                                            <input type="text" id="checkOutDate"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Select date" x-model="check_out_date" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Number of
                                                Rooms</label>
                                            <select
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                x-model="amount" required>
                                                <option selected value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        @if ($optionalServices->count() > 0)
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Room Options</label>
                                            <div class="space-y-3">
                                                @foreach ($optionalServices as $service)
                                                    <div class="flex items-center">
                                                        <input id="service{{ $service->id }}" type="checkbox"
                                                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                                            x-model="service{{ $service->id }}">
                                                        <label for="service{{ $service->id }}"
                                                            class="ml-3 text-xs text-gray-700">{{ $service->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 2: Guest Information -->
                                <div x-show="currentStep === 2" x-cloak>
                                    <h2 class="text-xl font-semibold mb-5 text-gray-800">Guest Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label for="first-name"
                                                class="block text-xs font-medium text-gray-700 mb-1">First
                                                Name</label>
                                            <input type="text" id="first-name"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter first name" x-model="first_name" required>
                                        </div>
                                        <div>
                                            <label for="last-name" class="block text-xs font-medium text-gray-700 mb-1">Last
                                                Name</label>
                                            <input type="text" id="last-name"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter last name" x-model="last_name" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label for="contact_email"
                                                class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                                            <input type="contact_email" id="contact_email"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter email address" x-model="contact_email" required>
                                        </div>
                                        <div>
                                            <label for="phone_number"
                                                class="block text-xs font-medium text-gray-700 mb-1">Phone Number</label>
                                            <input type="tel" id="phone_number"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter phone number" x-model="phone_number" required>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="address"
                                            class="block text-xs font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" id="address"
                                            class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                            placeholder="Enter street address" x-model="address" required>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                        <div>
                                            <label for="city"
                                                class="block text-xs font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" id="city"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter city" x-model="city">
                                        </div>
                                        <div>
                                            <label for="state"
                                                class="block text-xs font-medium text-gray-700 mb-1">State/Province</label>
                                            <input type="text" id="state"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter state" x-model="state">
                                        </div>
                                        <div>
                                            <label for="zip"
                                                class="block text-xs font-medium text-gray-700 mb-1">ZIP/Postal
                                                Code</label>
                                            <input type="text" id="zip"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Enter ZIP code" x-model="zipCode">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="country"
                                            class="block text-xs font-medium text-gray-700 mb-1">Country</label>
                                        <select id="country"
                                            class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                            x-model="country" required>
                                            <option value="">Select country</option>
                                            <option value="US">United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="AU">Australia</option>
                                            <option value="DE">Germany</option>
                                            <option value="FR">France</option>
                                            <option value="JP">Japan</option>
                                            <option value="CN">China</option>
                                            <option value="IN">India</option>
                                            <option value="BR">Brazil</option>
                                            <option value="LK">Sri lanka</option>
                                        </select>
                                    </div>

                                    <div class="mb-6">
                                        <label for="special-requests"
                                            class="block text-xs font-medium text-gray-700 mb-1">Special Requests
                                            (Optional)</label>
                                        <textarea id="special-requests" rows="3"
                                            class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                            placeholder="Enter any special requests or requirements" x-model="special_requests"></textarea>
                                        <p class="text-xs text-gray-400 mt-1">Special requests cannot be guaranteed but we
                                            will
                                            do our best to accommodate your needs.</p>
                                    </div>
                                </div>

                                <!-- Step 3: Payment Information -->
                                <div x-show="currentStep === 3" x-cloak>
                                    <h2 class="text-xl font-semibold mb-5 text-gray-800">Payment Information</h2>
                                    <div class="mb-6">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Payment Method</label>
                                        <div class="space-y-3">
                                            <div class="flex items-center">
                                                <input id="credit-card" name="payment-method" type="radio"
                                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                                    value="credit-card" x-model="paymentMethod" checked>
                                                <label for="credit-card" class="ml-3 text-xs text-gray-700">Credit
                                                    Card</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="offline-payment" name="payment-method" type="radio"
                                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                                    value="offline-payment" x-model="paymentMethod">
                                                <label for="offline-payment" class="ml-3 text-xs text-gray-700">Pay at
                                                    check-in</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Credit Card Form -->
                                    <div x-data="{ isChecked: paymentMethod === 'credit-card' }" x-show="paymentMethod === 'credit-card'"
                                        class="space-y-6">
                                        <div>
                                            <label for="card-holder"
                                                class="block text-xs font-medium text-gray-700 mb-1">Cardholder
                                                Name</label>
                                            <input type="text" id="card-holder"
                                                class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                placeholder="Name on card" x-model="cardholderName"
                                                :required="paymentMethod === 'credit-card'">
                                        </div>

                                        <div>
                                            <label for="card-number"
                                                class="block text-xs font-medium text-gray-700 mb-1">Card
                                                Number</label>
                                            <div class="relative">
                                                <input type="text" id="card-number"
                                                    class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                    placeholder="1234 5678 9012 3456" x-model="cardNumber" maxlength="19"
                                                    x-on:input="formatCardNumber"
                                                    :required="paymentMethod === 'credit-card'">
                                                <div class="absolute right-3 top-2.5 flex space-x-2">
                                                    <!-- Card SVGs -->
                                                    <svg class="h-5 w-8" viewBox="0 0 36 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="36" height="24" rx="4"
                                                            fill="#1434CB" />
                                                        <path d="M14.5 16.5H12L9 7.5H11.5L13.5 13.5L15.5 7.5H18L14.5 16.5Z"
                                                            fill="white" />
                                                        <path d="M18.5 16.5H21L22 7.5H19.5L18.5 16.5Z" fill="white" />
                                                        <path
                                                            d="M25.5 7.5C24.5 7.5 22.5 8 22.5 10C22.5 13 26 12.5 26 14C26 14.5 25.5 15 24.5 15C23.5 15 22 14.5 22 14.5L21.5 16.5C21.5 16.5 22.5 17 24.5 17C26.5 17 28.5 16 28.5 14C28.5 11 25 11.5 25 10C25 9.5 25.5 9 26.5 9C27.5 9 28.5 9.5 28.5 9.5L29 7.5C29 7.5 27.5 7.5 25.5 7.5Z"
                                                            fill="white" />
                                                    </svg>
                                                    <svg class="h-5 w-8" viewBox="0 0 36 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="36" height="24" rx="4"
                                                            fill="#FF5F00" />
                                                        <circle cx="13" cy="12" r="7" fill="#EB001B" />
                                                        <circle cx="23" cy="12" r="7" fill="#F79E1B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M18 17.5C19.3807 16.5222 20.2 14.8578 20.2 13C20.2 11.1422 19.3807 9.47778 18 8.5C16.6193 9.47778 15.8 11.1422 15.8 13C15.8 14.8578 16.6193 16.5222 18 17.5Z"
                                                            fill="#FF9F00" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-6">
                                            <div>
                                                <label for="expiry-date"
                                                    class="block text-xs font-medium text-gray-700 mb-1">Expiry
                                                    Date</label>
                                                <input type="text" id="expiry-date"
                                                    class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                    placeholder="MM/YY" x-model="expiryDate" maxlength="5"
                                                    x-on:input="formatExpiryDate"
                                                    :required="paymentMethod === 'credit-card'">
                                            </div>
                                            <div>
                                                <label for="cvv"
                                                    class="block text-xs font-medium text-gray-700 mb-1">CVV</label>
                                                <input type="text" id="cvv"
                                                    class="w-full px-4 py-2 border border-gray-200 rounded focus:ring-primary-500 focus:border-primary-500 text-sm"
                                                    placeholder="123" x-model="cvv" maxlength="4"
                                                    :required="paymentMethod === 'credit-card'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="terms" type="checkbox"
                                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                                    x-model="agreeToTerms" required>
                                            </div>
                                            <div class="ml-3 text-xs">
                                                <label for="terms" class="font-medium text-gray-700">I agree to the <a
                                                        href="#"
                                                        class="text-primary-600 hover:text-primary-500">Terms
                                                        and Conditions</a> and <a href="#"
                                                        class="text-primary-600 hover:text-primary-500">Privacy
                                                        Policy</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Review & Confirm -->
                                <div x-show="currentStep === 4" x-cloak>
                                    <h2 class="text-xl font-semibold mb-5 text-gray-800">Review & Confirm</h2>

                                    <div class="bg-gray-50 p-4 rounded mb-6 border">
                                        <h3 class="font-medium text-gray-900 mb-2">Reservation Details</h3>
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <p class="text-gray-500">Room Type</p>
                                                <p class="font-medium">Deluxe King Room</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Room Amount</p>
                                                <p class="font-medium" x-text="`${amount}`"></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Check-in</p>
                                                <p class="font-medium" x-text="check_in_date"></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Check-out</p>
                                                <p class="font-medium" x-text="check_out_date"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded mb-6 border">
                                        <h3 class="font-medium text-gray-900 mb-2">Guest Information</h3>
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <p class="text-gray-500">Name</p>
                                                <p class="font-medium" x-text="`${first_name} ${last_name}`"></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Email</p>
                                                <p class="font-medium" x-text="contact_email"></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Phone</p>
                                                <p class="font-medium" x-text="phone_number"></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Address</p>
                                                <p class="font-medium"
                                                    x-text="`${address}, ${city}, ${state} ${zipCode}, ${country}`"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded mb-6 border">
                                        <h3 class="font-medium text-gray-900 mb-2">Payment Method</h3>
                                        <div class="text-xs">
                                            <template x-if="paymentMethod === 'credit-card'">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-8 mr-2" viewBox="0 0 36 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="36" height="24" rx="4"
                                                            fill="#1434CB" />
                                                        <path d="M14.5 16.5H12L9 7.5H11.5L13.5 13.5L15.5 7.5H18L14.5 16.5Z"
                                                            fill="white" />
                                                        <path d="M18.5 16.5H21L22 7.5H19.5L18.5 16.5Z" fill="white" />
                                                        <path
                                                            d="M25.5 7.5C24.5 7.5 22.5 8 22.5 10C22.5 13 26 12.5 26 14C26 14.5 25.5 15 24.5 15C23.5 15 22 14.5 22 14.5L21.5 16.5C21.5 16.5 22.5 17 24.5 17C26.5 17 28.5 16 28.5 14C28.5 11 25 11.5 25 10C25 9.5 25.5 9 26.5 9C27.5 9 28.5 9.5 28.5 9.5L29 7.5C29 7.5 27.5 7.5 25.5 7.5Z"
                                                            fill="white" />
                                                    </svg>
                                                    <span x-text="`Card ending in ${cardNumber.slice(-4)}`"></span>
                                                </div>
                                            </template>
                                            <template x-if="paymentMethod === 'offline-payment'">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-8 mr-2" viewBox="0 0 36 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="36" height="24" rx="4"
                                                            fill="#F0F0F0" />
                                                        <path
                                                            d="M18 7.5C16.6193 7.5 15.8 8.47778 15.8 10C15.8 11.5222 16.6193 12.5 18 12.5C19.3807 12.5 20.2 11.5222 20.2 10C20.2 8.47778 19.3807 7.5 18 7.5Z"
                                                            fill="#0070E0" />
                                                        <path
                                                            d="M24.5 16H21L20.5 18H17L18.5 10H21C23 10 24.5 11 24.5 13C24.5 14.5 23.5 16 22 16H21L20.5 18H24L24.5 16Z"
                                                            fill="#003087" />
                                                    </svg>
                                                    <span>Pay at check-in</span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded mb-6 border">
                                        <h3 class="font-medium text-gray-900 mb-2">Special Requests</h3>
                                        <p class="text-xs" x-text="special_requests || 'None'"></p>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-10">
                                    <button type="button"
                                        class="px-4 py-2 border border-gray-300 rounded text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 text-sm"
                                        x-show="currentStep > 1" @click="prevStep">
                                        Previous
                                    </button>
                                    <div class="flex-1"></div>
                                    <button type="button"
                                        class="px-4 py-2 border border-transparent rounded shadow text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 text-sm"
                                        x-show="currentStep < totalSteps" @click="nextStep">
                                        Next
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded shadow text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                                        x-show="currentStep === totalSteps" :disabled="!agreeToTerms">
                                        Complete Reservation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Booking Summary -->
                    <div class="lg:w-5/12">
                        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 sticky top-6">
                            <div class="px-8 py-6 border-b">
                                <h2 class="text-xl font-bold text-gray-900">Booking Summary</h2>
                            </div>
                            <div class="px-8 py-6">
                                <div class="flex justify-between mb-4">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $hotel->name }}</h3>
                                        <p class="d-none text-xs text-gray-500">{{ $hotel->address }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="ml-1 text-xs font-medium">4.8</span>
                                    </div>
                                </div>

                                <div class="border-t border-b py-4 mb-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-500 text-xs">Check-in</span>
                                        <span class="font-medium text-xs" x-text="check_in_date || 'Select date'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 text-xs">Check-out</span>
                                        <span class="font-medium text-xs" x-text="check_out_date || 'Select date'"></span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-500 text-xs">{{ $roomType->name }}</span>
                                        <span class="font-medium text-xs">$<span x-text="roomBasePrice"></span> × <span
                                                x-text="calculateNights()"></span> nights</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-500 text-xs">Number of Rooms</span>
                                        <span class="font-medium text-xs" x-text="amount"></span>
                                    </div>
                                    @foreach ($optionalServices as $service)
                                        <div class="flex justify-between mb-2" x-show="service{{ $service->id }}">
                                            <span class="text-gray-500 text-xs">{{ $service->name }}</span>
                                            <span class="font-medium text-xs">$<span
                                                    x-text="calculateServiceTotal({{ $service->id }})"></span></span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="border-t pt-4">
                                    <div class="flex justify-between">
                                        <span class="font-semibold text-gray-800">Total</span>
                                        <span class="font-bold text-xl text-blue-700">$<span
                                                x-text="calculateTotal()"></span></span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">Includes taxes and fees</p>
                                </div>

                                <div class="mt-6 bg-green-50 p-4 rounded">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-medium text-green-800">Free cancellation until 24 hours
                                                before check-in</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div x-data="{ showModal: false }" x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                aria-labelledby="modal-title" role="dialog" aria-modal="true"
                @showConfirmation.window="showModal = true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"
                        @click="showModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
                        <div class="bg-white px-6 pt-5 pb-4 sm:p-8 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Reservation Confirmed!
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">
                                            Your reservation has been successfully confirmed. A confirmation email has been
                                            sent
                                            to your email address.
                                        </p>
                                        <div class="mt-4 bg-gray-50 p-4 rounded border">
                                            <p class="text-xs font-medium text-gray-900">Reservation Number: <span
                                                    class="text-primary-600">LUX-12345678</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse">
                            <a href="index.html"
                                class="w-full inline-flex justify-center rounded border border-transparent shadow px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-xs">
                                Return to Home
                            </a>
                            <button type="button"
                                class="mt-3 w-full inline-flex justify-center rounded border border-gray-300 shadow px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-xs"
                                @click="showModal = false">
                                View Reservation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        function reservationForm() {
            return {
                optionalServices: {!! $optionalServices->toJson() !!},
                roomBasePrice: {{ $roomType->base_price_per_night }},
                // Form steps
                currentStep: 1,
                totalSteps: 4,

                // Step 1: Room Selection
                hotelId: {{ $hotel->id }},
                roomTypeId: {{ $roomType->id }},
                check_in_date: '{{ $checkIn }}',
                check_out_date: '{{ $checkOut }}',
                amount: 1,
                selectedServices: [],

                // Define optional services
                service1: false,
                service2: false,
                service3: false,
                service4: false,
                service5: false,
                service6: false,

                // Step 2: Guest Information
                first_name: '',
                last_name: '',
                contact_email: '',
                phone_number: '',
                address: '',
                city: '',
                state: '',
                zipCode: '',
                country: '',
                special_requests: '',

                // Step 3: Payment Information
                paymentMethod: 'credit-card',
                cardholderName: '',
                cardNumber: '',
                expiryDate: '',
                cvv: '',
                agreeToTerms: false,
                has_credit_card_guarantee: this.paymentMethod === 'credit-card',

                init() {
                    this.initializeDatePickers();
                },

                initializeDatePickers() {
                    const today = new Date();
                    const tomorrow = new Date(today);
                    tomorrow.setDate(tomorrow.getDate() + 1);


                    flatpickr("#checkInDate", {
                        minDate: "today",
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.check_in_date = dateStr;
                            const checkOutPicker = document.querySelector("#checkOutDate")._flatpickr;
                            if (checkOutPicker) {
                                const minCheckOut = new Date(selectedDates[0]);
                                minCheckOut.setDate(minCheckOut.getDate() + 1);
                                checkOutPicker.set('minDate', minCheckOut);
                            }
                        }
                    });


                    flatpickr("#checkOutDate", {
                        minDate: tomorrow,
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.check_out_date = dateStr;
                        }
                    });
                },

                // Navigation methods
                nextStep() {
                    if (this.validateCurrentStep()) {
                        if (this.currentStep < this.totalSteps) {
                            this.currentStep++;
                        }
                    }
                },

                prevStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                    }
                },

                // Validation
                validateCurrentStep() {
                    switch (this.currentStep) {
                        case 1:
                            return this.validateStep1();
                        case 2:
                            return this.validateStep2();
                        case 3:
                            return this.validateStep3();
                        default:
                            return true;
                    }
                },

                validateStep1() {
                    if (!this.check_in_date || !this.check_out_date) {
                        alert('Please select check-in and check-out dates.');
                        return false;
                    }
                    return true;
                },

                validateStep2() {
                    const requiredFields = ['first_name', 'last_name', 'contact_email', 'phone_number', 'address', 'city',
                        'state', 'zipCode', 'country'
                    ];
                    for (let field of requiredFields) {
                        if (!this[field]) {
                            alert('Please fill in all required fields.');
                            return false;
                        }
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(this.contact_email)) {
                        alert('Please enter a valid email address.');
                        return false;
                    }

                    return true;
                },

                validateStep3() {
                    if (!this.agreeToTerms) {
                        alert('Please agree to the terms and conditions.');
                        return false;
                    }

                    if (this.paymentMethod === 'credit-card') {
                        const requiredFields = ['cardholderName', 'cardNumber', 'expiryDate', 'cvv'];
                        for (let field of requiredFields) {
                            if (!this[field]) {
                                alert('Please fill in all payment information.');
                                return false;
                            }
                        }

                        const cleanCardNumber = this.cardNumber.replace(/\s/g, '');
                        if (cleanCardNumber.length < 13 || cleanCardNumber.length > 19) {
                            alert('Please enter a valid card number.');
                            return false;
                        }

                        if (this.cvv.length < 3 || this.cvv.length > 4) {
                            alert('Please enter a valid CVV.');
                            return false;
                        }
                    }

                    return true;
                },
                calculateServiceTotal(serviceId) {
                    const service = this.optionalServices.find(s => s.id === serviceId);
                    console.log(service);

                    if (!service) return 0;

                    const nights = this.calculateNights();
                    return service.price * this.amount;
                },

                // Calculation methods
                calculateNights() {
                    if (!this.check_in_date || !this.check_out_date) return 0;

                    const checkIn = new Date(this.check_in_date);
                    const checkOut = new Date(this.check_out_date);
                    const timeDiff = checkOut.getTime() - checkIn.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    return nights > 0 ? nights : 0;
                },

                calculateTaxes() {
                    const subtotal = this.calculateSubtotal();
                    // return 0;
                    return Math.round(subtotal * 0.04); // 4% tax rate
                },

                calculateSubtotal() {
                    const nights = this.calculateNights();
                    const roomTotal = nights * this.roomBasePrice;

                    let selectedServicesTotal = 0;
                    this.selectedServices = [];
                    this.optionalServices.forEach(service => {
                        if (this[`service${service.id}`]) {
                            this.selectedServices.push(service.id);
                            selectedServicesTotal += this.calculateServiceTotal(service.id);
                        }
                    });

                    return roomTotal * this.amount + selectedServicesTotal;
                },

                calculateTotal() {
                    const subtotal = this.calculateSubtotal();
                    const taxes = this.calculateTaxes();
                    return subtotal + taxes;
                },

                formatCardNumber() {
                    let value = this.cardNumber.replace(/\D/g, '');

                    // Add spaces every 4 digits
                    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

                    this.cardNumber = value;
                },

                formatExpiryDate() {
                    let value = this.expiryDate.replace(/\D/g, '');

                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }

                    this.expiryDate = value;
                },

                // Form submission
                submitForm() {
                    if (!this.validateCurrentStep()) {
                        return;
                    }


                    let formData = new FormData();
                    formData.append('csrf_token', '{{ csrf_token() }}');
                    formData.append('hotel_id', this.hotelId);
                    formData.append('room_type_id', this.roomTypeId);
                    formData.append('check_in_date', this.check_in_date);
                    formData.append('check_out_date', this.check_out_date);
                    formData.append('amount', this.amount);
                    // formData.append('children', this.children);
                    formData.append('optional_services', JSON.stringify(this.selectedServices));
                    formData.append('first_name', this.first_name);
                    formData.append('last_name', this.last_name);
                    formData.append('contact_email', this.contact_email);
                    formData.append('phone_number', this.phone_number);
                    formData.append('address', this.address);
                    formData.append('city', this.city);
                    formData.append('state', this.state);
                    formData.append('zipCode', this.zipCode);
                    formData.append('country', this.country);
                    formData.append('special_requests', this.special_requests);
                    formData.append('paymentMethod', this.paymentMethod);
                    formData.append('has_credit_card_guarantee', this.has_credit_card_guarantee);
                    formData.append('total', this.calculateTotal());

                    console.log('Reservation submitted:');

                    // this.$dispatch('showConfirmation');


                    fetch('/hotels/{{ $hotel->id }}/reservations', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                            alert('Your reservation has been successfully processed.');
                            window.location.href = '/dashboard';
                            // this.$dispatch('showConfirmation');
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            alert('There was an error processing your reservation. Please try again.');
                        });
                }
            }
        }
    </script>
@endpush
