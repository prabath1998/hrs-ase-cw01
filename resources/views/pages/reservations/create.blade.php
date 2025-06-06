<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Reservation | Luxury Hotels</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Flatpickr for date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        [x-cloak] { display: none !important; }
        .form-progress-bar {
            height: 4px;
            transition: width 0.3s ease;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="index.html" class="text-2xl font-bold text-primary-600">LuxStay</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="index.html" class="text-gray-500 hover:text-gray-900">Home</a>
                    <a href="hotels.html" class="text-gray-500 hover:text-gray-900">Hotels</a>
                    <a href="become-a-partner.html" class="text-gray-500 hover:text-gray-900">Become a Partner</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">Contact</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="login.html" class="text-gray-500 hover:text-gray-900">Login</a>
                    <a href="register.html" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Sign Up</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="reservationForm()">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="index.html" class="text-gray-500 hover:text-gray-900 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="hotels.html" class="text-gray-500 hover:text-gray-900 ml-1 md:ml-2">Hotels</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="hotel-detail.html" class="text-gray-500 hover:text-gray-900 ml-1 md:ml-2">Grand Plaza Hotel</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500 ml-1 md:ml-2 font-medium">Reservation</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Reservation Form -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h1 class="text-2xl font-bold text-gray-900">Complete Your Reservation</h1>
                        <p class="text-gray-600 mt-1">Please fill in the details to confirm your booking</p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="relative h-1 bg-gray-200">
                        <div class="form-progress-bar bg-primary-500 absolute top-0 left-0" :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                    </div>

                    <!-- Form Steps -->
                    <form @submit.prevent="submitForm" class="p-6">
                        {{-- <input type="hidden" id="roomTypeId" value="{{ $roomType->id }}" x-model="roomTypeId">
                        <input type="hidden" id="appliedRateType" value="{{ $appliedRateType }}" x-model="appliedRateType">
                        <input type="hidden" id="hotelId" value="{{ $hotel->id }}" x-model="hotelId"> --}}

                        <!-- Step 1: Room Selection -->
                        <div x-show="currentStep === 1" x-cloak>
                            <h2 class="text-xl font-semibold mb-4">Room Selection</h2>
                            <div class="border rounded-lg overflow-hidden mb-6">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-1/3">
                                        <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Deluxe Room" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-4 md:w-2/3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-semibold">{{ $roomType->name }}</h3>
                                                <p class="text-gray-600 text-sm mt-1">1 King Bed • City View • 45m²</p>
                                                <div class="mt-2 flex items-center">
                                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="ml-1 text-gray-600">4.8 (120 reviews)</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-primary-600">$<span x-model="roomBasePrice" x-text="roomBasePrice"></span></p>
                                                <p class="text-gray-500 text-sm">per night</p>
                                                @if(isset($appliedRateType) && $appliedRateType !== 'Nightly')
                                                    <small class="text-muted fw-normal">({{ $appliedRateType }} Rate)</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="font-medium text-gray-900">Room Amenities:</h4>
                                            <ul class="mt-2 grid grid-cols-2 gap-x-4 gap-y-2 text-sm">

                                                @foreach ($roomType->features ?? [] as $feature)
                                                    <li class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
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
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
                                    <input type="text" id="check-in-date" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Select date" x-model="checkInDate" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-out Date</label>
                                    <input type="text" id="check-out-date" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Select date" x-model="checkOutDate" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Rooms</label>
                                    <select class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" x-model="amount" required>
                                        <option selected value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-6">
                                @if($optionalServices->count() > 0)
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Options</label>
                                    <div class="space-y-3">
                                        @foreach ($optionalServices as $service)
                                            <div class="flex items-center">
                                                <input id="service{{ $service->id }}" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" x-model="service{{ $service->id }}">
                                                <label for="service{{ $service->id }}" class="ml-3 text-sm text-gray-700">{{ $service->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Step 2: Guest Information -->
                        <div x-show="currentStep === 2" x-cloak>
                            <h2 class="text-xl font-semibold mb-4">Guest Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="first-name" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter first name" x-model="firstName" required>
                                </div>
                                <div>
                                    <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" id="last-name" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter last name" x-model="lastName" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="email" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter email address" x-model="email" required>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter phone number" x-model="phone" required>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" id="address" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter street address" x-model="address" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" id="city" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter city" x-model="city">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                    <input type="text" id="state" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter state" x-model="state">
                                </div>
                                <div>
                                    <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code</label>
                                    <input type="text" id="zip" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter ZIP code" x-model="zipCode">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <select id="country" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" x-model="country" required>
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
                                <label for="special-requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
                                <textarea id="special-requests" rows="3" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter any special requests or requirements" x-model="specialRequests"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Special requests cannot be guaranteed but we will do our best to accommodate your needs.</p>
                            </div>
                        </div>

                        <!-- Step 3: Payment Information -->
                        <div x-show="currentStep === 3" x-cloak>
                            <h2 class="text-xl font-semibold mb-4">Payment Information</h2>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input id="credit-card" name="payment-method" type="radio" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" value="credit-card" x-model="paymentMethod" checked>
                                        <label for="credit-card" class="ml-3 text-sm text-gray-700">Credit Card</label>
                                    </div>
                                    {{-- Pay after check in --}}
                                    <div class="flex items-center">
                                        <input id="offline-payment" name="payment-method" type="radio" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" value="offline-payment" x-model="paymentMethod">
                                        <label for="offline-payment" class="ml-3 text-sm text-gray-700">Pay at check-in</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Credit Card Form -->
                            <div x-show="paymentMethod === 'credit-card'" class="space-y-6">
                                <div>
                                    <label for="card-holder" class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                    <input type="text" id="card-holder" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Name on card" x-model="cardholderName" required>
                                </div>

                                <div>
                                    <label for="card-number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <div class="relative">
                                        <input type="text" id="card-number" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="1234 5678 9012 3456" x-model="cardNumber" maxlength="19" x-on:input="formatCardNumber" required>
                                        <div class="absolute right-3 top-2.5 flex space-x-2">
                                            <svg class="h-5 w-8" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="36" height="24" rx="4" fill="#1434CB"/>
                                                <path d="M14.5 16.5H12L9 7.5H11.5L13.5 13.5L15.5 7.5H18L14.5 16.5Z" fill="white"/>
                                                <path d="M18.5 16.5H21L22 7.5H19.5L18.5 16.5Z" fill="white"/>
                                                <path d="M25.5 7.5C24.5 7.5 22.5 8 22.5 10C22.5 13 26 12.5 26 14C26 14.5 25.5 15 24.5 15C23.5 15 22 14.5 22 14.5L21.5 16.5C21.5 16.5 22.5 17 24.5 17C26.5 17 28.5 16 28.5 14C28.5 11 25 11.5 25 10C25 9.5 25.5 9 26.5 9C27.5 9 28.5 9.5 28.5 9.5L29 7.5C29 7.5 27.5 7.5 25.5 7.5Z" fill="white"/>
                                            </svg>
                                            <svg class="h-5 w-8" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="36" height="24" rx="4" fill="#FF5F00"/>
                                                <circle cx="13" cy="12" r="7" fill="#EB001B"/>
                                                <circle cx="23" cy="12" r="7" fill="#F79E1B"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 17.5C19.3807 16.5222 20.2 14.8578 20.2 13C20.2 11.1422 19.3807 9.47778 18 8.5C16.6193 9.47778 15.8 11.1422 15.8 13C15.8 14.8578 16.6193 16.5222 18 17.5Z" fill="#FF9F00"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label for="expiry-date" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <input type="text" id="expiry-date" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="MM/YY" x-model="expiryDate" maxlength="5" x-on:input="formatExpiryDate" required>
                                    </div>
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" id="cvv" class="w-full px-4 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="123" x-model="cvv" maxlength="4" required>
                                    </div>
                                </div>
                            </div>

                            <!-- PayPal Message -->
                            <div x-show="paymentMethod === 'paypal'" class="bg-blue-50 p-4 rounded-md">
                                <p class="text-sm text-blue-800">
                                    You will be redirected to PayPal to complete your payment after reviewing your reservation.
                                </p>
                            </div>

                            <div class="mt-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" x-model="agreeToTerms" required>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary-600 hover:text-primary-500">Terms and Conditions</a> and <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review & Confirm -->
                        <div x-show="currentStep === 4" x-cloak>
                            <h2 class="text-xl font-semibold mb-4">Review & Confirm</h2>

                            <div class="bg-gray-50 p-4 rounded-md mb-6">
                                <h3 class="font-medium text-gray-900 mb-2">Reservation Details</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm">
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
                                        <p class="font-medium" x-text="checkInDate"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Check-out</p>
                                        <p class="font-medium" x-text="checkOutDate"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-md mb-6">
                                <h3 class="font-medium text-gray-900 mb-2">Guest Information</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Name</p>
                                        <p class="font-medium" x-text="`${firstName} ${lastName}`"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Email</p>
                                        <p class="font-medium" x-text="email"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Phone</p>
                                        <p class="font-medium" x-text="phone"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Address</p>
                                        <p class="font-medium" x-text="`${address}, ${city}, ${state} ${zipCode}, ${country}`"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-md mb-6">
                                <h3 class="font-medium text-gray-900 mb-2">Payment Method</h3>
                                <div class="text-sm">
                                    <template x-if="paymentMethod === 'credit-card'">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-8 mr-2" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="36" height="24" rx="4" fill="#1434CB"/>
                                                <path d="M14.5 16.5H12L9 7.5H11.5L13.5 13.5L15.5 7.5H18L14.5 16.5Z" fill="white"/>
                                                <path d="M18.5 16.5H21L22 7.5H19.5L18.5 16.5Z" fill="white"/>
                                                <path d="M25.5 7.5C24.5 7.5 22.5 8 22.5 10C22.5 13 26 12.5 26 14C26 14.5 25.5 15 24.5 15C23.5 15 22 14.5 22 14.5L21.5 16.5C21.5 16.5 22.5 17 24.5 17C26.5 17 28.5 16 28.5 14C28.5 11 25 11.5 25 10C25 9.5 25.5 9 26.5 9C27.5 9 28.5 9.5 28.5 9.5L29 7.5C29 7.5 27.5 7.5 25.5 7.5Z" fill="white"/>
                                            </svg>
                                            <span x-text="`Card ending in ${cardNumber.slice(-4)}`"></span>
                                        </div>
                                    </template>
                                    <template x-if="paymentMethod === 'paypal'">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-8 mr-2" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="36" height="24" rx="4" fill="#F0F0F0"/>
                                                <path d="M24.5 7.5C24.5 9.5 23 11 21 11H18.5L18 13.5H15L16.5 5H21C23 5 24.5 6 24.5 7.5Z" fill="#003087"/>
                                                <path d="M28 9.5C28 11.5 26.5 13 24.5 13H22L21.5 15.5H18.5L20 7H24.5C26.5 7 28 8 28 9.5Z" fill="#0070E0"/>
                                            </svg>
                                            <span>PayPal</span>
                                        </div>
                                    </template>
                                    <template x-if="paymentMethod === 'offline-payment'">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-8 mr-2" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="36" height="24" rx="4" fill="#F0F0F0"/>
                                                <path d="M18 7.5C16.6193 7.5 15.8 8.47778 15.8 10C15.8 11.5222 16.6193 12.5 18 12.5C19.3807 12.5 20.2 11.5222 20.2 10C20.2 8.47778 19.3807 7.5 18 7.5Z" fill="#0070E0"/>
                                                <path d="M24.5 16H21L20.5 18H17L18.5 10H21C23 10 24.5 11 24.5 13C24.5 14.5 23.5 16 22 16H21L20.5 18H24L24.5 16Z" fill="#003087"/>
                                            </svg>
                                            <span>Pay at check-in</span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-md mb-6">
                                <h3 class="font-medium text-gray-900 mb-2">Special Requests</h3>
                                <p class="text-sm" x-text="specialRequests || 'None'"></p>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-8">
                            <button
                                type="button"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                x-show="currentStep > 1"
                                @click="prevStep"
                            >
                                Previous
                            </button>
                            <div class="flex-1"></div>
                            <button
                                type="button"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                x-show="currentStep < totalSteps"
                                @click="nextStep"
                            >
                                Next
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                x-show="currentStep === totalSteps"
                                :disabled="!agreeToTerms"
                            >
                                Complete Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-900">Booking Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between mb-4">
                            <div>
                                <h3 class="font-semibold">{{ $hotel->name }}</h3>
                                <p class="d-none text-sm text-gray-600">Miami, Florida</p>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium">4.8</span>
                            </div>
                        </div>

                        <div class="border-t border-b py-4 mb-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Check-in</span>
                                <span class="font-medium" x-text="checkInDate || 'Select date'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Check-out</span>
                                <span class="font-medium" x-text="checkOutDate || 'Select date'"></span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">{{ $roomType->name }}</span>
                                <span class="font-medium">$<span x-text="roomBasePrice"></span> × <span x-text="calculateNights()"></span> nights</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Number of Rooms</span>
                                <span class="font-medium" x-text="amount"></span>
                            </div>
                            @foreach ($optionalServices as $service)
                                <div class="flex justify-between mb-2" x-show="service{{ $service->id }}">
                                    <span class="text-gray-600">{{ $service->name }}</span>
                                    <span class="font-medium">$<span x-text="calculateServiceTotal({{ $service->id }})"></span></span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between">
                                <span class="font-semibold">Total</span>
                                <span class="font-bold text-xl">$<span x-text="calculateTotal()"></span></span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Includes taxes and fees</p>
                        </div>

                        <div class="mt-6 bg-green-50 p-4 rounded-md">
                            <div class="flex">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-green-800">Free cancellation until 24 hours before check-in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About LuxStay</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Press Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Investor Relations</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Destinations</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Miami</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">New York</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Los Angeles</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Chicago</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Safety Information</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Cancellation Options</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">COVID-19 Response</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Subscribe to our newsletter</h3>
                    <p class="text-gray-300 mb-4">Get the latest offers and updates</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary-500 text-gray-900">
                        <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-r-md hover:bg-primary-700">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-300">&copy; 2023 LuxStay. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-300 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Confirmation Modal -->
    <div
        x-data="{ showModal: false }"
        x-show="showModal"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
        @show-confirmation.window="showModal = true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
                @click="showModal = false"
            ></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Reservation Confirmed!
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Your reservation has been successfully confirmed. A confirmation email has been sent to your email address.
                                </p>
                                <div class="mt-4 bg-gray-50 p-4 rounded-md">
                                    <p class="text-sm font-medium text-gray-900">Reservation Number: <span class="text-primary-600">LUX-12345678</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a href="index.html" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Return to Home
                    </a>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                        View Reservation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reservationForm() {
            return {
                optionalServices: {!! $optionalServices->toJson() !!},
                roomBasePrice: {!! $roomType->base_price_per_night !!},
                // Form steps
                currentStep: 1,
                totalSteps: 4,

                // Step 1: Room Selection
                hotelId: '{{ $hotel->id }}',
                roomTypeId: '{{ $roomType->id }}',
                checkInDate: '',
                checkOutDate: '',
                amount: 1,
                // children: '0',
                selectedServices: [],

                // Define optional services
                service1: false,
                service2: false,
                service3: false,
                service4: false,
                service5: false,
                service6: false,

                // Step 2: Guest Information
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                state: '',
                zipCode: '',
                country: '',
                specialRequests: '',

                // Step 3: Payment Information
                paymentMethod: 'credit-card',
                cardholderName: '',
                cardNumber: '',
                expiryDate: '',
                cvv: '',
                agreeToTerms: false,

                init() {
                    this.initializeDatePickers();
                },

                initializeDatePickers() {
                    const today = new Date();
                    const tomorrow = new Date(today);
                    tomorrow.setDate(tomorrow.getDate() + 1);


                    flatpickr("#check-in-date", {
                        minDate: "today",
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.checkInDate = dateStr;
                            const checkOutPicker = document.querySelector("#check-out-date")._flatpickr;
                            if (checkOutPicker) {
                                const minCheckOut = new Date(selectedDates[0]);
                                minCheckOut.setDate(minCheckOut.getDate() + 1);
                                checkOutPicker.set('minDate', minCheckOut);
                            }
                        }
                    });


                    flatpickr("#check-out-date", {
                        minDate: tomorrow,
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.checkOutDate = dateStr;
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
                    if (!this.checkInDate || !this.checkOutDate) {
                        alert('Please select check-in and check-out dates.');
                        return false;
                    }
                    return true;
                },

                validateStep2() {
                    const requiredFields = ['firstName', 'lastName', 'email', 'phone', 'address', 'city', 'state', 'zipCode', 'country'];
                    for (let field of requiredFields) {
                        if (!this[field]) {
                            alert('Please fill in all required fields.');
                            return false;
                        }
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(this.email)) {
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
                    return (nights * service.price) * this.amount;
                },

                // Calculation methods
                calculateNights() {
                    if (!this.checkInDate || !this.checkOutDate) return 0;

                    const checkIn = new Date(this.checkInDate);
                    const checkOut = new Date(this.checkOutDate);
                    const timeDiff = checkOut.getTime() - checkIn.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    return nights > 0 ? nights : 0;
                },

                calculateTaxes() {
                    const subtotal = this.calculateSubtotal();
                    // return 0;
                    return Math.round(subtotal * 0.4); // 4% tax rate
                },

                calculateSubtotal() {
                    const nights = this.calculateNights();
                    const roomTotal = nights * this.roomBasePrice;

                    let selectedServicesTotal = 0;
                    this.optionalServices.forEach(service => {
                        if (this[`service${service.id}`]) {
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
                    formData.append('checkInDate', this.checkInDate);
                    formData.append('checkOutDate', this.checkOutDate);
                    formData.append('amount', this.amount);
                    // formData.append('children', this.children);
                    formData.append('addBreakfast', this.addBreakfast);
                    formData.append('earlyCheckin', this.earlyCheckin);
                    formData.append('lateCheckout', this.lateCheckout);
                    formData.append('firstName', this.firstName);
                    formData.append('lastName', this.lastName);
                    formData.append('email', this.email);
                    formData.append('phone', this.phone);
                    formData.append('address', this.address);
                    formData.append('city', this.city);
                    formData.append('state', this.state);
                    formData.append('zipCode', this.zipCode);
                    formData.append('country', this.country);
                    formData.append('specialRequests', this.specialRequests);
                    formData.append('paymentMethod', this.paymentMethod);
                    formData.append('total', this.calculateTotal());

                    console.log('Reservation submitted:');

                    this.$dispatch('show-confirmation');


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
                        this.$dispatch('show-confirmation');
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('There was an error processing your reservation. Please try again.');
                    });
                }
            }
        }
    </script>
</body>
</html>
