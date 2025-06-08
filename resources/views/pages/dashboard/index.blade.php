<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>{{ __('Dashboard') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js CDN -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Lucide Icons CDN -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-gray-50" x-data="dashboardPage()">
  <!-- Header -->
  <header class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-4">
          <a href="/" class="text-2xl font-bold text-blue-600">HotelHub</a>
          <span class="text-gray-400">|</span>
          <span class="text-gray-600">Dashboard</span>
        </div>
        <div class="flex items-center space-x-4">
          <button class="relative bg-transparent hover:bg-gray-100 rounded p-2">
            <i data-lucide="bell" class="w-4 h-4"></i>
            <span class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></span>
          </button>
          <a href="/reservation" class="border px-4 py-2 rounded hover:bg-gray-100">New Booking</a>
          <a href="/" class="flex items-center px-2 py-2 hover:bg-gray-100 rounded">
            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
            Logout
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
      <div class="flex items-center space-x-4 mb-6">
        <img src="{{ asset('images/user/user-01.jpg') }}" alt="User" class="h-16 w-16 rounded-full object-cover" />
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Welcome back, John!</h1>
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
              <p class="text-2xl font-bold">1</p>
              <p class="text-xs text-green-600">+1 from last month</p>
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
              <p class="text-2xl font-bold">12</p>
              <p class="text-xs text-blue-600">Across 8 hotels</p>
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
              <p class="text-2xl font-bold">$18,542</p>
              <p class="text-xs text-gray-600">This year</p>
            </div>
          </div>
        </div>
        <div class="hidden bg-white rounded shadow hover:shadow-lg transition-shadow">
          <div class="p-6 flex items-center space-x-4">
            <div class="bg-yellow-100 p-3 rounded-full">
              <i data-lucide="star" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div>
              <p class="text-sm text-gray-600">Loyalty Points</p>
              <p class="text-2xl font-bold">2,847</p>
              <p class="text-xs text-yellow-600">Gold Member</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabs -->
    <div x-data="{ tab: 'overview' }" class="space-y-6">
      <div class="grid w-full grid-cols-5 mb-4">
        <button :class="tab==='overview' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='overview'" class="py-2 px-4 border-b">Overview</button>
        <button :class="tab==='reservations' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='reservations'" class="py-2 px-4 border-b">Reservations</button>
        <button :class="tab==='billing' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='billing'" class="py-2 px-4 border-b">Billing</button>
        <button :class="tab==='favorites' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='favorites'" class="py-2 px-4 border-b">Favorites</button>
        <button :class="tab==='reviews' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='reviews'" class="hidden py-2 px-4 border-b">Reviews</button>
        <button :class="tab==='profile' ? 'bg-blue-100 text-blue-700' : 'bg-white text-gray-700'" @click="tab='profile'" class="py-2 px-4 border-b">Profile</button>
      </div>

      <!-- Overview Tab -->
      <div x-show="tab==='overview'" class="space-y-6">
        <div class="grid lg:grid-cols-2 gap-6">
          <!-- Upcoming Reservations -->
          <div class="bg-white rounded shadow">
            <div class="p-6 border-b flex items-center justify-between">
              <h2 class="font-bold text-lg">Upcoming Reservations</h2>
              <a href="/reservation" class="border px-3 py-1 rounded hover:bg-gray-100 text-sm">Book New</a>
            </div>
            <div class="p-6" id="upcoming-reservations"></div>
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
                <div>
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
            <a href="/reservation" class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
              <i data-lucide="plus" class="w-6 h-6 mb-2"></i>
              New Booking
            </a>
            <button class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
              <i data-lucide="calendar" class="w-6 h-6 mb-2"></i>
              Modify Booking
            </button>
            <button class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
              <i data-lucide="download" class="w-6 h-6 mb-2"></i>
              Download Receipt
            </button>
            <button class="flex flex-col items-center justify-center border rounded h-20 hover:bg-gray-50">
              <i data-lucide="settings" class="w-6 h-6 mb-2"></i>
              Account Settings
            </button>
          </div>
        </div>
      </div>

      <!-- Reservations Tab -->
      <div x-show="tab==='reservations'" class="space-y-6">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-bold">My Reservations</h2>
          <div class="flex space-x-3">
            <select class="border rounded px-3 py-2 w-40">
              <option>All Reservations</option>
              <option>Upcoming</option>
              <option>Completed</option>
              <option>Cancelled</option>
            </select>
            <a href="/reservation" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book New Stay</a>
          </div>
        </div>
        <div class="space-y-4" id="all-reservations"></div>
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
              <button class="border px-4 py-2 rounded w-full flex items-center justify-center hover:bg-gray-50">
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
            <div class="p-6 space-y-4" id="billing-history"></div>
          </div>
        </div>
      </div>

      <!-- Favorites Tab -->
      <div x-show="tab==='favorites'" class="space-y-6">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-bold">Saved Hotels</h2>
          <a href="/" class="border px-4 py-2 rounded hover:bg-gray-100">Browse More Hotels</a>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="saved-hotels"></div>
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
        <div class="grid md:grid-cols-2 gap-6">
          <!-- Personal Information -->
          <div class="bg-white rounded shadow">
            <div class="p-6 border-b">
              <h2 class="font-bold text-lg">Personal Information</h2>
              <p class="text-sm text-gray-500">Update your personal details</p>
            </div>
            <form class="p-6 space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="firstName" class="block text-sm font-medium">First Name</label>
                  <input id="firstName" class="border rounded px-3 py-2 w-full" value="John" />
                </div>
                <div>
                  <label for="lastName" class="block text-sm font-medium">Last Name</label>
                  <input id="lastName" class="border rounded px-3 py-2 w-full" value="Doe" />
                </div>
              </div>
              <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" type="email" class="border rounded px-3 py-2 w-full" value="john.doe@example.com" />
              </div>
              <div>
                <label for="phone" class="block text-sm font-medium">Phone</label>
                <input id="phone" type="tel" class="border rounded px-3 py-2 w-full" value="+1 (555) 123-4567" />
              </div>
              <div>
                <label for="dateOfBirth" class="block text-sm font-medium">Date of Birth</label>
                <input id="dateOfBirth" type="date" class="border rounded px-3 py-2 w-full" value="1990-05-15" />
              </div>
              <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded flex items-center hover:bg-blue-700">
                <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                Save Changes
              </button>
            </form>
          </div>
          <!-- Travel Preferences -->
          <div class="bg-white rounded shadow">
            <div class="p-6 border-b">
              <h2 class="font-bold text-lg">Travel Preferences</h2>
              <p class="text-sm text-gray-500">Customize your booking experience</p>
            </div>
            <form class="p-6 space-y-4">
              <div>
                <label for="roomType" class="block text-sm font-medium">Preferred Room Type</label>
                <select id="roomType" class="border rounded px-3 py-2 w-full">
                  <option>Standard Room</option>
                  <option>Deluxe Room</option>
                  <option selected>Executive Suite</option>
                  <option>Presidential Suite</option>
                </select>
              </div>
              <div>
                <label for="bedType" class="block text-sm font-medium">Bed Type Preference</label>
                <select id="bedType" class="border rounded px-3 py-2 w-full">
                  <option>Twin Beds</option>
                  <option>Queen Bed</option>
                  <option selected>King Bed</option>
                </select>
              </div>
              <div>
                <label for="specialRequests" class="block text-sm font-medium">Special Requests</label>
                <input id="specialRequests" class="border rounded px-3 py-2 w-full" value="High floor, ocean view" />
              </div>
              <div class="space-y-3">
                <label class="block text-sm font-medium">Preferred Amenities</label>
                <div class="grid grid-cols-2 gap-2">
                  <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" checked class="rounded" />
                    <span>Free WiFi</span>
                  </label>
                  <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" checked class="rounded" />
                    <span>Fitness Center</span>
                  </label>
                  <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" class="rounded" />
                    <span>Swimming Pool</span>
                  </label>
                  <label class="flex items-center space-x-2 text-sm"></label>
                    <input type="checkbox" checked class="rounded" />
                    <span>Spa Services</span>
                  </label>
                </div>
              </div>
              <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded flex items-center hover:bg-blue-700">
                <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                Update Preferences
              </button>
            </form>
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
          <!-- Loyalty Program -->
          <div class="bg-white rounded shadow">
            <div class="p-6 border-b">
              <h2 class="font-bold text-lg">Loyalty Program</h2>
              <p class="text-sm text-gray-500">Your membership status and benefits</p>
            </div>
            <div class="p-6 space-y-4">
              <div class="text-center p-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg text-white">
                <i data-lucide="star" class="w-8 h-8 mx-auto mb-2"></i>
                <h4 class="text-lg font-bold">Gold Member</h4>
                <p class="text-sm opacity-90">2,847 points</p>
              </div>
              <div class="space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-sm">Progress to Platinum</span>
                  <span class="text-sm font-medium">2,847 / 5,000 points</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-yellow-600 h-2 rounded-full" style="width: 57%"></div>
                </div>
                <p class="text-xs text-gray-600">2,153 points needed for Platinum status</p>
              </div>
              <div class="space-y-2">
                <h5 class="font-medium">Current Benefits:</h5>
                <ul class="text-sm text-gray-600 space-y-1">
                  <li>• 10% bonus points on all bookings</li>
                  <li>• Free room upgrades (subject to availability)</li>
                  <li>• Late checkout until 2 PM</li>
                  <li>• Priority customer support</li>
                  <li>• Complimentary breakfast at select hotels</li>
                </ul>
              </div>
              <button class="bg-yellow-600 text-white px-4 py-2 rounded w-full flex items-center justify-center hover:bg-yellow-700">
                <i data-lucide="star" class="w-4 h-4 mr-2"></i>
                Redeem Points
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Alpine.js Data and Rendering -->
  <script>
    function dashboardPage() {
      return {
        // Data from your mock arrays
        reservations: [
          {
            id: "RES-001",
            roomName: "Presidential Suite",
            roomImage: "{{ asset('images/hero-hotel.jpg') }}",
            hotelName: "HotelHub Miami Beach",
            checkIn: "2024-02-15",
            checkOut: "2024-02-18",
            guests: 2,
            status: "confirmed",
            total: 4347,
            nights: 3,
            amenities: ["Ocean View", "Butler Service", "Private Terrace"],
          },
          {
            id: "RES-002",
            roomName: "Executive Suite",
            roomImage: "/images/executive-suite.jpg",
            hotelName: "HotelHub Downtown",
            checkIn: "2024-01-10",
            checkOut: "2024-01-12",
            guests: 2,
            status: "completed",
            total: 1348,
            nights: 2,
            amenities: ["City View", "Executive Lounge", "Balcony"],
          },
          {
            id: "RES-003",
            roomName: "Deluxe Room",
            roomImage: "/images/deluxe-room.jpg",
            hotelName: "HotelHub Resort",
            checkIn: "2023-12-20",
            checkOut: "2023-12-23",
            guests: 1,
            status: "cancelled",
            total: 1047,
            nights: 3,
            amenities: ["Garden View", "Mini Bar", "Free WiFi"],
          },
        ],
        billing: [
          {
            id: "INV-001",
            date: "2024-01-12",
            description: "Executive Suite - 2 nights",
            amount: 1348,
            status: "paid",
            reservationId: "RES-002",
            paymentMethod: "Visa ****4242",
          },
          {
            id: "INV-002",
            date: "2023-12-23",
            description: "Deluxe Room - 3 nights (Refunded)",
            amount: -1047,
            status: "refunded",
            reservationId: "RES-003",
            paymentMethod: "Mastercard ****8888",
          },
          {
            id: "INV-003",
            date: "2023-11-15",
            description: "Deluxe Room - 2 nights",
            amount: 748,
            status: "paid",
            reservationId: "RES-004",
            paymentMethod: "Visa ****4242",
          },
        ],
        hotels: [
          {
            id: 1,
            name: "HotelHub Miami Beach",
            location: "Miami Beach, FL",
            image: "/images/hero-hotel.jpg",
            rating: 4.9,
            price: 299,
            amenities: ["Beach Access", "Spa", "Pool", "Restaurant"],
          },
          {
            id: 2,
            name: "HotelHub Downtown",
            location: "New York, NY",
            image: "/images/executive-suite.jpg",
            rating: 4.7,
            price: 399,
            amenities: ["City View", "Gym", "Business Center", "WiFi"],
          },
          {
            id: 3,
            name: "HotelHub Resort",
            location: "Aspen, CO",
            image: "/images/presidential-suite.jpg",
            rating: 4.8,
            price: 599,
            amenities: ["Mountain View", "Ski Access", "Spa", "Restaurant"],
          },
        ],
        reviews: [
          {
            id: 1,
            hotelName: "HotelHub Miami Beach",
            roomType: "Executive Suite",
            rating: 5,
            title: "Exceptional stay with outstanding service",
            review:
              "The hotel exceeded all expectations. The staff was incredibly attentive, the room was spacious and beautifully appointed, and the ocean view was breathtaking. The spa services were world-class, and the dining options were excellent. I would definitely stay here again.",
            date: "2024-01-15",
            helpful: 12,
            images: ["/images/executive-suite.jpg"],
          },
          {
            id: 2,
            hotelName: "HotelHub Downtown",
            roomType: "Deluxe Room",
            rating: 4,
            title: "Great location and comfortable stay",
            review:
              "Perfect location in the heart of the city. The room was clean and comfortable, though a bit smaller than expected. The staff was friendly and helpful. The business center was well-equipped for my work needs.",
            date: "2023-12-20",
            helpful: 8,
            images: ["/images/deluxe-room.jpg"],
          },
        ],
        init() {
          // Render Upcoming Reservations
          document.getElementById('upcoming-reservations').innerHTML = this.reservations
            .filter(r => r.status === "confirmed")
            .slice(0, 2)
            .map(r => `
              <div class="flex items-center space-x-4 p-4 border rounded-lg mb-4 last:mb-0">
                <img src="${r.roomImage}" alt="${r.roomName}" class="rounded object-cover w-20 h-16" />
                <div class="flex-1">
                  <h4 class="font-semibold">${r.roomName}</h4>
                  <p class="text-sm text-gray-600">${r.hotelName}</p>
                  <p class="text-sm text-gray-600">${formatDate(r.checkIn, "MMM dd")} - ${formatDate(r.checkOut, "MMM dd, yyyy")}</p>
                </div>
                <div class="text-right">
                  ${getStatusBadge(r.status)}
                  <p class="text-sm font-bold mt-1">$${r.total}</p>
                </div>
              </div>
            `).join('');

          // Render All Reservations
          document.getElementById('all-reservations').innerHTML = this.reservations.map(r => `
            <div class="bg-white rounded shadow hover:shadow-lg transition-shadow">
              <div class="p-6 grid md:grid-cols-4 gap-6">
                <div class="relative">
                  <img src="${r.roomImage}" alt="${r.roomName}" class="rounded-lg object-cover w-full h-32" />
                  <div class="absolute top-2 left-2">${getStatusBadge(r.status)}</div>
                </div>
                <div class="md:col-span-2">
                  <div class="flex items-start justify-between mb-2">
                    <div>
                      <h3 class="text-xl font-bold">${r.roomName}</h3>
                      <p class="text-gray-600">${r.hotelName}</p>
                    </div>
                  </div>
                  <p class="text-gray-600 mb-2">Reservation ID: ${r.id}</p>
                  <div class="space-y-1 text-sm text-gray-600 mb-3">
                    <div class="flex items-center space-x-2">
                      <i data-lucide="calendar" class="w-4 h-4"></i>
                      <span>${formatDate(r.checkIn, "MMM dd, yyyy")} - ${formatDate(r.checkOut, "MMM dd, yyyy")}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                      <i data-lucide="user" class="w-4 h-4"></i>
                      <span>${r.guests} guests • ${r.nights} nights</span>
                    </div>
                  </div>
                  <div class="flex flex-wrap gap-1">
                    ${r.amenities.map(a => `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">${a}</span>`).join('')}
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-2xl font-bold mb-2">$${r.total}</p>
                  <div class="space-y-2">
                    <button class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50">
                      <i data-lucide="eye" class="w-4 h-4 mr-2"></i>View Details
                    </button>
                    ${r.status === "confirmed" ? `
                    <button class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50">
                      <i data-lucide="edit" class="w-4 h-4 mr-2"></i>Modify
                    </button>` : ''}
                    <button class="border px-3 py-1 rounded w-full flex items-center justify-center hover:bg-gray-50">
                      <i data-lucide="download" class="w-4 h-4 mr-2"></i>Receipt
                    </button>
                  </div>
                </div>
              </div>
            </div>
          `).join('');

          // Render Billing History
          document.getElementById('billing-history').innerHTML = this.billing.map(b => `
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div class="flex items-center space-x-4">
                <div class="bg-gray-100 p-2 rounded">
                  <i data-lucide="credit-card" class="w-5 h-5 text-gray-600"></i>
                </div>
                <div>
                  <p class="font-semibold">${b.description}</p>
                  <p class="text-sm text-gray-600">${formatDate(b.date, "MMM dd, yyyy")} • ${b.id}</p>
                  <p class="text-xs text-gray-500">${b.paymentMethod}</p>
                </div>
              </div>
              <div class="text-right flex items-center space-x-4">
                <div>
                  <p class="font-bold text-lg">$${Math.abs(b.amount)}</p>
                  ${getPaymentStatusBadge(b.status)}
                </div>
                <button class="border px-2 py-2 rounded hover:bg-gray-50">
                  <i data-lucide="download" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          `).join('');

          // Render Saved Hotels
          document.getElementById('saved-hotels').innerHTML = this.hotels.map(h => `
            <div class="bg-white rounded shadow overflow-hidden hover:shadow-xl transition-shadow group">
              <div class="relative h-48">
                <img src="${h.image}" alt="${h.name}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300" />
                <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded p-2">
                  <i data-lucide="heart" class="w-4 h-4 text-red-500 fill-current"></i>
                </button>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-bold mb-1">${h.name}</h3>
                <div class="flex items-center space-x-2 mb-2">
                  <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                  <span class="text-gray-600 text-sm">${h.location}</span>
                </div>
                <div class="flex items-center mb-3">
                  <div class="flex text-yellow-400">
                    ${[...Array(5)].map((_, i) => `<i data-lucide="star" class="w-4 h-4 ${i < Math.round(h.rating) ? 'fill-current' : ''}"></i>`).join('')}
                  </div>
                  <span class="ml-2 text-sm text-gray-600">${h.rating}</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-4">
                  ${h.amenities.slice(0, 3).map(a => `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">${a}</span>`).join('')}
                </div>
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-sm text-gray-600">From</p>
                    <p class="text-xl font-bold">$${h.price}<span class="text-sm font-normal">/night</span></p>
                  </div>
                  <a href="/reservation" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Book Now</a>
                </div>
              </div>
            </div>
          `).join('');

          // Render Reviews
          document.getElementById('reviews-list').innerHTML = this.reviews.map(r => `
            <div class="bg-white rounded shadow">
              <div class="p-6 flex items-start space-x-4">
                <img src="${r.images[0]}" alt="${r.hotelName}" class="rounded-lg object-cover w-20 h-20" />
                <div class="flex-1">
                  <div class="flex items-start justify-between mb-2">
                    <div>
                      <h3 class="text-lg font-bold">${r.hotelName}</h3>
                      <p class="text-gray-600">${r.roomType}</p>
                    </div>
                    <div class="text-right">
                      <div class="flex text-yellow-400 mb-1">
                        ${[...Array(5)].map((_, i) => `<i data-lucide="star" class="w-4 h-4 ${i < r.rating ? 'fill-current' : ''}"></i>`).join('')}
                      </div>
                      <p class="text-sm text-gray-600">${formatDate(r.date, "MMM dd, yyyy")}</p>
                    </div>
                  </div>
                  <div class="mb-4">
                    <h4 class="font-semibold mb-2">"${r.title}"</h4>
                    <p class="text-gray-700">${r.review}</p>
                  </div>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                      <span>${r.helpful} people found this helpful</span>
                    </div>
                    <div class="flex space-x-2">
                      <button class="border px-3 py-1 rounded flex items-center hover:bg-gray-50">
                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit
                      </button>
                      <button class="border px-3 py-1 rounded flex items-center hover:bg-gray-50">
                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `).join('');

          // Render Lucide icons
          lucide.createIcons();
        }
      }
    }

    // Helper functions
    function formatDate(dateStr, format) {
      const date = new Date(dateStr);
      const options = {};
      if (format.includes('MMM')) options.month = 'short';
      if (format.includes('dd')) options.day = '2-digit';
      if (format.includes('yyyy')) options.year = 'numeric';
      return date.toLocaleDateString('en-US', options);
    }
    function getStatusBadge(status) {
      if (status === "confirmed") {
        return `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Confirmed</span>`;
      }
      if (status === "completed") {
        return `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Completed</span>`;
      }
      if (status === "cancelled") {
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

    // Initialize Alpine.js data and render on DOMContentLoaded
    document.addEventListener('alpine:init', () => {
      Alpine.data('dashboardPage', dashboardPage);
    });
  </script>
</body>
</html>
