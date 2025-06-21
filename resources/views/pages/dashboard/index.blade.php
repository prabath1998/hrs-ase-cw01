@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-gray-50" x-data="dashboardPage()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">

            {{-- Flash Messages --}}
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @elseif (session('error'))
                <x-alert type="error" :message="session('error')" />
            @elseif (session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @elseif (session('info'))
                <x-alert type="info" :message="session('info')" />
            @endif

            @if( $errors->any())
                <x-alert type="error" :message="$errors->first()"/>
            @endif

            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-6">
                    <img src="{{ asset('images/user/user-01.jpg') }}" alt="User"
                        class="h-16 w-16 rounded-full object-cover" />
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
                        <p class="text-gray-600">
                            Manage your reservations, view your travel history, and discover new destinations
                        </p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded shadow hover:shadow-lg transition-shadow">
                        <div class="p-6 flex items-center space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Active Reservations</p>
                                <p class="text-2xl font-bold">{{ $lastMonthReservationCount }}</p>
                                <p class="text-xs text-green-600">+ {{ $lastMonthReservationCount }} from last month</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded shadow hover:shadow-lg transition-shadow">
                        <div class="p-6 flex items-center space-x-4">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Completed Stays</p>
                                <p class="text-2xl font-bold">{{ $totalReservations }}</p>
                                <p class="text-xs text-blue-600">Across {{ $totalReservationHotelCount }} hotels</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded shadow hover:shadow-lg transition-shadow">
                        <div class="p-6 flex items-center space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i data-lucide="credit-card" class="w-6 h-6 text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Spent</p>
                                <p class="text-2xl font-bold">${{ $totalSpent }}</p>
                                <p class="text-xs text-gray-600">This year</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'overview' }" class="space-y-6">
                <div class="grid w-full grid-cols-4 mb-4">
                    <button :class="tab === 'overview' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'"
                        @click="tab='overview'" class="py-2 px-4 border-b">Overview</button>
                    <button :class="tab === 'reservations' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'"
                        @click="tab='reservations'" class="py-2 px-4 border-b">Reservations</button>
                    <button :class="tab === 'billing' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'"
                        @click="tab='billing'" class="py-2 px-4 border-b">Billing</button>
                    <button :class="tab === 'profile' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'"
                        @click="tab='profile'" class="py-2 px-4 border-b">Profile</button>
                </div>

                <!-- Overview Tab -->
                <div x-show="tab==='overview'" class="space-y-6">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Upcoming Reservations -->
                        <div class="bg-white rounded shadow">
                            <div class="p-6 border-b flex items-center justify-between">
                                <h2 class="font-bold text-lg">Upcoming Reservations</h2>
                                <a href="{{ route('hotels.index') }}"
                                    class="border px-3 py-1 rounded hover:bg-gray-100 text-sm">Book
                                    New</a>
                            </div>
                            <div class="p-6" id="upcoming-reservations">
                                <template x-for="r in reservations.filter(r => (r.status === 'confirmed_guaranteed' || r.status === 'pending_confirmation' || r.status === 'confirmed_no_cc_hold') ).slice(0, 2)"
                                    :key="r.id">
                                    <div class="flex items-center space-x-4 p-4 border rounded-lg mb-4 last:mb-0">
                                        <img :src="r.roomImage" :alt="r.roomName"
                                            class="rounded object-cover w-20 h-16" />
                                        <div class="flex-1">
                                            <h4 class="font-semibold" x-text="r.roomName"></h4>
                                            <p class="text-sm text-gray-600" x-text="r.hotelName"></p>
                                            <p class="text-sm text-gray-600"
                                                x-text="formatDate(r.checkIn, 'MMM dd yyyy') + ' - ' + formatDate(r.checkOut, 'MMM dd, yyyy')">
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span x-html="getStatusBadge(r.status)"></span>
                                            <p class="text-sm font-bold mt-1" x-text="'$' + r.total"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!-- Recent Activity -->
                        <div class="bg-white rounded shadow">
                            <div class="p-6 border-b">
                                <h2 class="font-bold text-lg">Recent Activity</h2>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Booking Confirmed</p>
                                        <p class="text-sm text-gray-600">Presidential Suite - Feb 15-18</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <i data-lucide="star" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <div class="hidden">
                                        <p class="font-medium">Review Posted</p>
                                        <p class="text-sm text-gray-600">Executive Suite - 5 stars</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="bg-purple-100 p-2 rounded-full">
                                        <i data-lucide="credit-card" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Payment Processed</p>
                                        <p class="text-sm text-gray-600">$1,348 - Visa ****4242</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Actions -->
                    <div class="bg-white rounded shadow">
                        <div class="p-6 border-b">
                            <h2 class="font-bold text-lg">Quick Actions</h2>
                        </div>
                        <div class="p-6 grid md:grid-cols-4 gap-4">
                            <a href="{{ route('hotels.index') }}"
                                class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
                                <i data-lucide="plus" class="w-6 h-6 mb-2"></i>
                                New Booking
                            </a>
                            <button @click="tab='reservations'"
                                class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
                                <i data-lucide="calendar" class="w-6 h-6 mb-2"></i>
                                Modify Booking
                            </button>
                            <button @click="tab='billing'"
                                class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
                                <i data-lucide="download" class="w-6 h-6 mb-2"></i>
                                Download Receipt
                            </button>
                            <button @click="tab='profile'"
                                class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
                                <i data-lucide="settings" class="w-6 h-6 mb-2"></i>
                                Account Settings
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Reservations Tab -->
                <div x-show="tab==='reservations'" x-data="{ view: false, edit: false, selectedReservation: undefined, paymentMethodEdit: false }" class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">My Reservations</h2>
                        <div class="flex space-x-3">
                            <select class="border rounded px-3 py-2 w-40">
                                <option>All Reservations</option>
                                <option>Upcoming</option>
                                <option>Completed</option>
                                <option>Cancelled</option>
                            </select>
                            <a href="{{ route('hotels.index') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book
                                New Stay</a>
                        </div>
                    </div>
                    <div class="space-y-4" id="all-reservations">
                        <template x-for="r in reservations" :key="r.id">
                            <div class="bg-white rounded shadow hover:shadow-lg transition-shadow">
                                <div class="p-6 grid md:grid-cols-4 gap-6">
                                    <div class="relative">
                                        <img :src="r.roomImage" :alt="r.roomName"
                                            class="rounded-lg object-cover w-full h-32" />
                                        <div class="absolute top-2 left-2" x-html="getStatusBadge(r.status)"></div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="text-xl font-bold" x-text="r.roomName"></h3>
                                                <p class="text-gray-600" x-text="r.hotelName"></p>
                                            </div>
                                        </div>
                                        <p class="text-gray-600 mb-2">Reservation ID: <span x-text="r.id"></span></p>
                                        <div class="space-y-1 text-sm text-gray-600 mb-3">
                                            <div class="flex items-center space-x-2">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                                <span
                                                    x-text="formatDate(r.checkIn, 'MMM dd, yyyy') + ' - ' + formatDate(r.checkOut, 'MMM dd, yyyy')"></span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <i data-lucide="user" class="w-4 h-4"></i>
                                                <span x-text="r.guests + ' guests • ' + r.nights + ' nights'"></span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-1">
                                            <template x-for="a in r.amenities" :key="a">
                                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs"
                                                    x-text="a"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold mb-2" x-text="'$' + r.priceBreakdown.grandTotal"></p>
                                        <div class="space-y-2">
                                            <button
                                                class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50"
                                                @click="selectedReservation = r; view = true; $nextTick(() => {lucide.createIcons()});">
                                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>View
                                            </button>
                                            <button
                                                class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50"
                                                @click="selectedReservation = r; edit = true">
                                                <i data-lucide="square-pen" class="w-4 h-4 mr-2"></i>Edit
                                            </button>
                                            <button
                                                class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50"
                                                @click="downloadReservationReceipt(r.id)">
                                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>Receipt
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <x-modal-reservation selectedReservation="selectedReservation" view="view" edit="edit"
                        paymentMethodEdit="paymentMethodEdit" />

                </div>

                <!-- Billing Tab -->
                <div x-show="tab==='billing'" class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Billing History</h2>
                        <button class="border px-4 py-2 rounded flex items-center hover:bg-gray-100">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Download All
                        </button>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-6">
                        <!-- Payment Methods -->
                        <div class="bg-white rounded shadow">
                            <div class="p-6 border-b">
                                <h2 class="font-bold text-lg">Payment Methods</h2>
                                <p class="text-sm text-gray-500">Manage your saved payment methods</p>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between p-3 border rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-100 p-2 rounded">
                                            <i data-lucide="credit-card" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Visa ****4242</p>
                                            <p class="text-sm text-gray-600">Expires 12/2027</p>
                                        </div>
                                    </div>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Default</span>
                                </div>
                                <div class="flex items-center justify-between p-3 border rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-red-100 p-2 rounded">
                                            <i data-lucide="credit-card" class="w-4 h-4 text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Mastercard ****8888</p>
                                            <p class="text-sm text-gray-600">Expires 08/2026</p>
                                        </div>
                                    </div>
                                    <button class="hover:bg-gray-100 rounded p-2">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <button
                                    class="border px-4 py-2 rounded w-full flex items-center justify-center hover:bg-gray-50">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Add Payment Method
                                </button>
                            </div>
                        </div>
                        <!-- Payment History -->
                        <div class="bg-white rounded shadow lg:col-span-2">
                            <div class="p-6 border-b">
                                <h2 class="font-bold text-lg">Payment History</h2>
                                <p class="text-sm text-gray-500">View and download your payment receipts</p>
                            </div>
                            <div class="p-6 space-y-4" id="billing-history">
                                <template x-for="b in billing" :key="b.id">
                                    <div class="flex items-center justify-between p-4 border rounded-lg">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-gray-100 p-2 rounded">
                                                <i data-lucide="credit-card" class="w-5 h-5 text-gray-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold" x-text="b.description"></p>
                                                <p class="text-sm text-gray-600"
                                                    x-text="formatDate(b.date, 'MMM dd, yyyy') + ' - ' + b.id"></p>
                                                <p class="text-xs text-gray-500" x-text="b.paymentMethod"></p>
                                            </div>
                                        </div>
                                        <div class="text-right flex items-center space-x-4">
                                            <div>
                                                <p class="font-bold text-lg">$<span x-text="Math.abs(b.amount)"></span>
                                                </p>
                                                <span x-html="getPaymentStatusBadge(b.status)"></span>
                                            </div>
                                            <button class="border px-2 py-2 rounded hover:bg-gray-50"
                                                @click="downloadPaymentReceipt(b.id)">
                                                <i data-lucide="download" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div x-show="tab==='reviews'" class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">My Reviews</h2>
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-600">
                                Average rating: <span class="font-bold">4.5★</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center hover:bg-blue-700">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Write Review
                            </button>
                        </div>
                    </div>
                    <div class="space-y-6" id="reviews-list"></div>
                </div>

                <!-- Profile Tab -->
                <div x-show="tab==='profile'" class="space-y-6">
                    <h2 class="text-2xl font-bold">Profile Settings</h2>
                    <form class="p-6 space-y-4" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="bg-white rounded shadow flex flex-col gap-4 px-4 py-2">
                                <div class="p-6 border-b">
                                    <h2 class="font-bold text-lg">Personal Information</h2>
                                    <p class="text-sm text-gray-500">Update your personal details</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="firstName" class="block text-sm font-medium">First Name</label>
                                        <input id="firstName" name="first_name" class="border rounded px-3 py-2 w-full"
                                            value="{{ $customerDetails['first_name'] }}" />
                                        @error('first_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="lastName" class="block text-sm font-medium">Last Name</label>
                                        <input id="lastName" name="last_name" class="border rounded px-3 py-2 w-full"
                                            value="{{ $customerDetails['last_name'] }}" />
                                        @error('last_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium">Email</label>
                                    <input id="contact_email" type="email" class="border rounded px-3 py-2 w-full bg-gray-100"
                                        value="{{ $customerDetails['contact_email'] }}" readonly />
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium">Phone Number</label>
                                    <input id="phone_number" name="phone_number" type="text"
                                        class="border rounded px-3 py-2 w-full"
                                        value="{{ $customerDetails['phone_number'] }}" />
                                    @error('phone_number')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium">Address</label>
                                    <textarea id="address" name="address" class="border rounded px-3 py-2 w-full" rows="3">{{ $customerDetails['address'] }}</textarea>
                                </div>

                                <!-- Update Password -->
                                <div class="border-t pt-4">
                                    <h3 class="font-semibold text-lg">Update Password</h3>
                                    <p class="text-sm text-gray-500">Change your account password</p>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label for="currentPassword" class="block text-sm font-medium">Current
                                                Password</label>
                                            <input id="currentPassword" type="password" name="current_password"
                                                class="border rounded px-3 py-2 w-full" />
                                            @error('current_password')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="newPassword" class="block text-sm font-medium">New
                                                Password</label>
                                            <input id="newPassword" type="password" name="new_password"
                                                class="border rounded px-3 py-2 w-full" />
                                            @error('new_password')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="confirmPassword" class="block text-sm font-medium">Confirm
                                            Password</label>
                                        <input id="confirmPassword" type="password" name="confirm_password"
                                            class="border rounded px-3 py-2 w-full" />
                                        @error('confirm_password')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded flex self-end hover:bg-blue-700">
                                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                                    Save Changes
                                </button>

                            </div>
                            <!-- Notification Settings -->
                            <div class="bg-white rounded shadow">
                                <div class="p-6 border-b">
                                    <h2 class="font-bold text-lg">Notification Settings</h2>
                                    <p class="text-sm text-gray-500">Choose how you want to receive updates</p>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">Email Notifications</p>
                                            <p class="text-sm text-gray-600">Booking confirmations and updates</p>
                                        </div>
                                        <input type="checkbox" checked class="rounded" />
                                    </div>
                                    <hr />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">SMS Notifications</p>
                                            <p class="text-sm text-gray-600">Important booking updates</p>
                                        </div>
                                        <input type="checkbox" class="rounded" />
                                    </div>
                                    <hr />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">Marketing Emails</p>
                                            <p class="text-sm text-gray-600">Special offers and deals</p>
                                        </div>
                                        <input type="checkbox" checked class="rounded" />
                                    </div>
                                    <hr />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">Push Notifications</p>
                                            <p class="text-sm text-gray-600">Mobile app notifications</p>
                                        </div>
                                        <input type="checkbox" checked class="rounded" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function dashboardPage() {
            return {
                reservations: {!! json_encode($reservations) !!},
                billing: {!! json_encode($bills) !!},
                availableOptionalServices: {!! json_encode($availableOptionalServices) !!},
                downloadReservationReceipt(id) {
                    window.location.href = `/reservations/${id}/receipt/download`;
                },
                downloadPaymentReceipt(id) {
                    window.location.href = `/payments/${id}/receipt/download`;
                },
            }
        }

        function formatDate(dateStr, format) {
            const date = new Date(dateStr);
            const options = {};
            if (format.includes('MMM')) options.month = 'short';
            if (format.includes('dd')) options.day = '2-digit';
            if (format.includes('yyyy')) options.year = 'numeric';
            return date.toLocaleDateString('en-US', options);
        }

        function getStatusBadge(status) {
            if (status === "pending_confirmation") {
                return `<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="clock" class="w-3 h-3 mr-1"></i>Pending Confirmation</span>`;
            }
            if (status === "confirmed_guaranteed") {
                return `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Confirmed</span>`;
            }
            if (status === "confirmed_no_cc_hold") {
                return `<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="clock" class="w-3 h-3 mr-1"></i>Confirmed - No CC Hold</span>`;
            }
            if (status === "checked_in") {
                return `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Checked In</span>`;
            }
            if (status === "checked_out") {
                return `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Checked Out</span>`;
            }
            if (status === "no_show") {
                return `<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>No Show</span>`;
            }

            if (status === "completed") {
                return `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Completed</span>`;
            }
            if (status === "cancelled_customer" || status === "cancelled_system") {
                return `<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="clock" class="w-3 h-3 mr-1"></i>Cancelled</span>`;
            }
            return `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">${status}</span>`;
        }

        function getPaymentStatusBadge(status) {
            if (status === "paid") {
                return `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Paid</span>`;
            }
            if (status === "refunded") {
                return `<span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Refunded</span>`;
            }
            if (status === "pending") {
                return `<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>`;
            }
            return `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">${status}</span>`;
        }

        document.addEventListener('DOMContentLoaded', function() {

            flatpickr("#newCheckIn", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    const checkOutPicker = flatpickr("#newCheckOut");
                    checkOutPicker.set('minDate', selectedDates[0]);
                    if (selectedDates.length > 0) {
                        checkOutPicker.setDate(selectedDates[0], true);
                    }
                }
            });

            flatpickr("#newCheckOut", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    const checkInPicker = flatpickr("#newCheckIn");
                    checkInPicker.set('maxDate', selectedDates[0]);
                }
            });
        });
    </script>
@endpush
