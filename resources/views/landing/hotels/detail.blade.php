@extends('layouts.guest')


@section('content')
    <div x-data="hotelPage()" class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-show="hotel">
            <!-- Hotel Header -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2" x-text="hotel.name"></h1>
                        <div class="flex items-center space-x-4 mb-2">
                            <div class="flex items-center">
                                <!-- Star SVG -->
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <polygon
                                        points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27" />
                                </svg>
                                <span class="ml-1 font-semibold" x-text="hotel.rating"></span>
                                <span class="ml-1 text-gray-600" x-text="'(' + hotel.reviewCount + ' reviews)'"></span>
                            </div>
                            <template x-if="hotel.awards.length">
                                <span class="bg-yellow-600 text-white px-2 py-1 rounded text-xs flex items-center">
                                    <!-- Award SVG -->
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <circle cx="12" cy="8" r="7" />
                                        <path
                                            d="M8.21 13.89l-1.42 4.24a1 1 0 0 0 1.45 1.12L12 17.77l3.76 1.48a1 1 0 0 0 1.45-1.12l-1.42-4.24" />
                                    </svg>
                                    Award Winner
                                </span>
                            </template>
                            <template x-if="hotel.sustainability.length">
                                <span class="bg-green-600 text-white px-2 py-1 rounded text-xs flex items-center">
                                    <!-- Leaf SVG -->
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M2 22s16-4 20-16c0 0-7 2-10 9-2 4-8 7-8 7z" />
                                    </svg>
                                    Eco-Friendly
                                </span>
                            </template>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <!-- MapPin SVG -->
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span x-text="hotel.address"></span>
                        </div>
                    </div>
                    <div class="text-right mt-4 lg:mt-0">
                        <p class="text-sm text-gray-600">Starting from</p>
                        <p class="text-3xl font-bold text-blue-600" x-text="'$' + hotel.priceFrom + '/night'"></p>
                    </div>
                </div>
                <p class="text-gray-700 text-lg" x-text="hotel.description"></p>
            </div>

            <!-- Image Gallery -->
            <div class="mb-8">
                <div class="grid grid-cols-4 gap-4 h-96">
                    <div class="col-span-2 relative rounded-lg overflow-hidden">
                        <img :src="hotel.images[selectedImageIndex] || '/placeholder.svg'" :alt="hotel.name"
                            class="object-cover w-full h-full absolute inset-0" />
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all cursor-pointer">
                        </div>
                    </div>
                    <div class="col-span-2 grid grid-cols-2 gap-4">
                        <template x-for="(image, index) in hotel.images.slice(1, 5)" :key="index">
                            <div class="relative rounded-lg overflow-hidden cursor-pointer"
                                @click="selectedImageIndex = index + 1">
                                <img :src="image || '/placeholder.svg'" :alt="hotel.name + ' ' + (index + 2)"
                                    class="object-cover w-full h-full absolute inset-0" />
                                <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="flex justify-center mt-4 space-x-2">
                    <template x-for="(img, index) in hotel.images" :key="index">
                        <button @click="selectedImageIndex = index"
                            :class="selectedImageIndex === index ? 'bg-blue-600' : 'bg-gray-300'"
                            class="w-3 h-3 rounded-full"></button>
                    </template>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Tabs -->
                    <div x-data="{ tab: 'overview' }" class="space-y-6">
                        <div class="grid w-full grid-cols-5 mb-4">
                            <button :class="tab === 'overview' ? 'border-b-2 border-blue-600 font-bold' : ''" class="py-2"
                                @click="tab='overview'">Overview</button>
                            <button :class="tab === 'rooms' ? 'border-b-2 border-blue-600 font-bold' : ''" class="py-2"
                                @click="tab='rooms'">Rooms</button>
                            <button :class="tab === 'amenities' ? 'border-b-2 border-blue-600 font-bold' : ''"
                                class="py-2" @click="tab='amenities'">Amenities</button>
                            <button :class="tab === 'location' ? 'border-b-2 border-blue-600 font-bold' : ''"
                                class="py-2" @click="tab='location'">Location</button>
                            <button :class="tab === 'reviews' ? 'border-b-2 border-blue-600 font-bold' : ''"
                                class="py-2 hidden" @click="tab='reviews'">Reviews</button>
                        </div>

                        <!-- Overview Tab -->
                        <div x-show="tab==='overview'" class="space-y-6">
                            <div class="bg-white rounded-lg shadow p-6">
                                <h2 class="font-bold text-xl mb-2">About This Hotel</h2>
                                <p class="text-gray-700 mb-4" x-text="hotel.description"></p>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold mb-2">Key Features</h4>
                                        <ul class="space-y-1">
                                            <template x-for="feature in hotel.features" :key="feature">
                                                <li class="flex items-center">
                                                    <!-- CheckCircle SVG -->
                                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M9 12l2 2l4-4" />
                                                        <circle cx="12" cy="12" r="10" />
                                                    </svg>
                                                    <span class="text-sm" x-text="feature"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-2">Awards & Recognition</h4>
                                        <ul class="space-y-1">
                                            <template x-for="award in hotel.awards" :key="award">
                                                <li class="flex items-center">
                                                    <!-- Award SVG -->
                                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="8" r="7" />
                                                        <path
                                                            d="M8.21 13.89l-1.42 4.24a1 1 0 0 0 1.45 1.12L12 17.77l3.76 1.48a1 1 0 0 0 1.45-1.12l-1.42-4.24" />
                                                    </svg>
                                                    <span class="text-sm" x-text="award"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg shadow p-6">
                                <h2 class="font-bold text-xl mb-2">Hotel Policies</h2>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <!-- Clock SVG -->
                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 6v6l4 2" />
                                            </svg>
                                            <span class="font-medium"
                                                x-text="'Check-in: ' + hotel.policies.checkIn"></span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 6v6l4 2" />
                                            </svg>
                                            <span class="font-medium"
                                                x-text="'Check-out: ' + hotel.policies.checkOut"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2l4-4" />
                                                <circle cx="12" cy="12" r="10" />
                                            </svg>
                                            <span class="text-sm" x-text="hotel.policies.cancellation"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span class="font-medium">Pets: </span>
                                            <span class="ml-2"
                                                :class="hotel.policies.pets ? 'text-green-600' : 'text-red-600'"
                                                x-text="hotel.policies.pets ? 'Allowed' : 'Not Allowed'"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium">Smoking: </span>
                                            <span class="ml-2"
                                                :class="hotel.policies.smoking ? 'text-green-600' : 'text-red-600'"
                                                x-text="hotel.policies.smoking ? 'Allowed' : 'Not Allowed'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rooms Tab -->
                        <div x-show="tab==='rooms'" class="space-y-6">
                            <template x-for="room in hotel.rooms" :key="room.id">
                                <div @click="selectedRoom = room.id"
                                    :class="selectedRoom === room.id ? 'ring-2 ring-blue-500' : ''"
                                    class="bg-white rounded-lg shadow p-6 cursor-pointer transition-all">
                                    <div class="grid md:grid-cols-3 gap-6">
                                        <div class="relative h-48 rounded-lg overflow-hidden">
                                            <img :src="room.images || '/placeholder.svg'" :alt="room.name"
                                                class="object-cover w-full h-full absolute inset-0" />
                                            <template x-if="room.popularChoice">
                                                <span
                                                    class="absolute top-2 left-2 bg-yellow-600 text-white px-2 py-1 rounded text-xs">Popular
                                                    Choice</span>
                                            </template>
                                        </div>
                                        <div class="md:col-span-2">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <h3 class="text-xl font-bold" x-text="room.name"></h3>
                                                    <p class="text-gray-600" x-text="room.description"></p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-bold text-blue-600"
                                                        x-text="'$' + room.originalPrice + '/Night'"
                                                        :class="room.isSuite ? 'line-through text-sm text-gray-600' : 'text-xl'">
                                                    </p>
                                                    <template x-if="room.discount">
                                                        <span class="text-sm text-red-600"
                                                            x-text="'Save ' + room.discount + '%!'"></span>
                                                    </template>
                                                    <template x-if="room.isSuite">
                                                        <div>
                                                            <p class="text-xl font-bold text-blue-600">
                                                                {{-- Show weekly rate and monthly rate --}}
                                                                <span
                                                                    x-text="'$' + room.suiteWeeklyRate + '/Week'"></span><br>
                                                                <span
                                                                    x-text="'$' + room.suiteMonthlyRate + '/Month'"></span>
                                                            </p>

                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4 text-sm text-gray-600">
                                                <div x-text="'Max: ' + room.maxGuests + ' guests'"></div>
                                            </div>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                <template x-for="amenity in room.amenities" :key="amenity">
                                                    <span class="bg-gray-200 px-2 py-1 rounded text-xs"
                                                        x-text="amenity"></span>
                                                </template>
                                            </div>
                                            <template x-if="room.lastBooked">
                                                <p class="text-sm text-orange-600 mb-2"
                                                    x-text="'🔥 Last booked ' + room.lastBooked"></p>
                                            </template>
                                            <template x-if="selectedRoom === room.id">
                                                <div class="bg-blue-50 p-3 rounded-lg">
                                                    <p class="text-blue-800 font-medium">✓ Selected for booking</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Amenities Tab -->
                        <div x-show="tab==='amenities'" class="space-y-6">
                            <div class="bg-white rounded-lg shadow p-6">
                                <h2 class="font-bold text-xl mb-2">Hotel Amenities</h2>
                                <div class="grid md:grid-cols-3 gap-6">
                                    <template x-for="amenity in hotel.amenities" :key="amenity">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2l4-4" />
                                                <circle cx="12" cy="12" r="10" />
                                            </svg>
                                            <span x-text="amenity"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <template x-if="hotel.sustainability.length">
                                <div class="bg-white rounded-lg shadow p-6">
                                    <h2 class="font-bold text-xl mb-2 flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M2 22s16-4 20-16c0 0-7 2-10 9-2 4-8 7-8 7z" />
                                        </svg>
                                        Sustainability Initiatives
                                    </h2>
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <template x-for="initiative in hotel.sustainability" :key="initiative">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M2 22s16-4 20-16c0 0-7 2-10 9-2 4-8 7-8 7z" />
                                                </svg>
                                                <span x-text="initiative"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Location Tab -->
                        <div x-show="tab==='location'" class="space-y-6">
                            <div class="bg-white rounded-lg shadow p-6">
                                <h2 class="font-bold text-xl mb-2">Location & Nearby Attractions</h2>
                                <div class="mb-6">
                                    <h4 class="font-semibold mb-2">Address</h4>
                                    <p class="text-gray-700" x-text="hotel.address"></p>
                                </div>
                                <div class="mb-6">
                                    <h4 class="font-semibold mb-2">Nearby Attractions</h4>
                                    <div class="space-y-2">
                                        <template x-for="attraction in hotel.nearbyAttractions" :key="attraction">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-gray-600 mr-2" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z" />
                                                    <circle cx="12" cy="10" r="3" />
                                                </svg>
                                                <span x-text="attraction"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2">Contact Information</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M22 16.92V19a2 2 0 0 1-2.18 2A19.72 19.72 0 0 1 3 5.18 2 2 0 0 1 5 3h2.09a2 2 0 0 1 2 1.72c.13 1.05.37 2.07.72 3.06a2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c.99.35 2.01.59 3.06.72A2 2 0 0 1 22 16.92z" />
                                            </svg>
                                            <span x-text="hotel.contact.phone"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M4 4h16v16H4z" />
                                                <path d="M22 6l-10 7L2 6" />
                                            </svg>
                                            <span x-text="hotel.contact.email"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M2 12h20" />
                                                <path
                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                            </svg>
                                            <span x-text="hotel.contact.website"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="tab==='reviews'" class="space-y-6">
                            <div class="bg-white rounded-lg shadow p-6">
                                <h2 class="font-bold text-xl mb-2">Guest Reviews</h2>
                                <div class="text-center mb-6">
                                    <div class="text-4xl font-bold text-blue-600 mb-2" x-text="hotel.rating"></div>
                                    <div class="flex justify-center mb-2">
                                        <template x-for="i in 5">
                                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                <polygon
                                                    points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27" />
                                            </svg>
                                        </template>
                                    </div>
                                    <p class="text-gray-600" x-text="'Based on ' + hotel.reviewCount + ' reviews'"></p>
                                </div>
                                <div class="space-y-4">
                                    <!-- Example reviews, replace with your data -->
                                    <div class="border-b pb-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="flex text-yellow-400">
                                                    <template x-for="i in 5">
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                            <polygon
                                                                points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27" />
                                                        </svg>
                                                    </template>
                                                </div>
                                                <span class="ml-2 font-semibold">John D.</span>
                                            </div>
                                            <span class="text-sm text-gray-600">2 days ago</span>
                                        </div>
                                        <p class="text-gray-700">
                                            "Exceptional service and beautiful accommodations. The staff went above and
                                            beyond to make our stay memorable."
                                        </p>
                                    </div>
                                    <div class="border-b pb-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="flex text-yellow-400">
                                                    <template x-for="i in 4">
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                            <polygon
                                                                points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27" />
                                                        </svg>
                                                    </template>
                                                    <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24">
                                                        <polygon
                                                            points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27" />
                                                    </svg>
                                                </div>
                                                <span class="ml-2 font-semibold">Sarah M.</span>
                                            </div>
                                            <span class="text-sm text-gray-600">1 week ago</span>
                                        </div>
                                        <p class="text-gray-700">
                                            "Great location and amenities. The room was spacious and clean. Would definitely
                                            stay here again."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-24 space-y-4">
                        <h2 class="font-bold text-xl mb-2">Book Your Stay</h2>
                        <div>
                            <label for="checkInDate" class="block text-sm font-medium mb-2">Check-in Date</label>
                            <input id="checkInDate" type="date" class="w-full border rounded px-3 py-2"
                                x-model="checkIn" :min="today" />
                        </div>
                        <div>
                            <label for="checkOutDate" class="block text-sm font-medium mb-2">Check-out Date</label>
                            <input id="checkOutDate" type="date" class="w-full border rounded px-3 py-2"
                                x-model="checkOut" :min="checkIn || today" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Guests</label>
                            <select class="w-full border rounded px-3 py-2" x-model="guests">
                                <option value="1">1 Guest</option>
                                <option value="2">2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                                <option value="5">5 Guests</option>
                                <option value="6">6+ Guests</option>
                            </select>
                        </div>
                        <template x-if="checkIn && checkOut">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Duration:</span>
                                    <span x-text="multiplier + ' ' + appliedRateType"></span>
                                </div>
                                <template x-if="selectedRoom">
                                    <div class="flex justify-between text-sm">
                                        <span>Room rate:</span>
                                        <span
                                            x-text="'$' + appliedRate + '/' + getAppliedRateText(appliedRateType)"></span>
                                    </div>
                                </template>
                                <template x-if="availabilityCount > 0">
                                    <div class="flex justify-between text-sm text-green-600 mt-1">
                                        <span>Availability:</span>
                                        <span x-text="availabilityCount + ' rooms available'"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        {{-- Check Availability button --}}
                        <button class="w-full bg-blue-600 text-white py-2 rounded disabled:opacity-50"
                            :disabled="!checkIn || !checkOut || !selectedRoom" @click="checkAvailability">
                            <span>Check Availability</span>
                        </button>

                        <button class="w-full bg-blue-600 text-white py-2 rounded disabled:opacity-50"
                            :disabled="!checkIn || !checkOut || !selectedRoom || availabilityCount === 0"
                            @click="bookNow">
                            <span x-text="selectedRoom ? 'Book Now' : 'Select a Room First'"></span>
                        </button>
                        <div class="text-center text-sm text-gray-600">
                            <p>✓ Free cancellation until 6 PM</p>
                            <p>✓ Best price guarantee</p>
                            <p>✓ Instant confirmation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Not found -->
        <div x-show="!hotel" class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-2xl font-bold mb-4">Hotel not found</h1>
                <a href="/hotels" class="bg-blue-600 text-white px-4 py-2 rounded">Back to Hotels</a>
            </div>
        </div>

    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {


        });


        function hotelPage() {
            // Example hotel data, replace with your own data source
            const hotel = {
                id: {{ $hotel->id }},
                name: "{{ $hotel->name }}",
                rating: {{ $hotel->rating }},
                reviewCount: 0,
                priceFrom: "{{ $priceFrom }}",
                description: "{{ $hotel->description }}",
                address: "{{ $hotel->address }}",
                images: ({!! json_encode($hotel->images) !!}),
                features: ({!! json_encode($hotel->features) !!}),
                awards: ["Best Luxury Hotel 2023"],
                sustainability: [],
                policies: {
                    checkIn: "{{ \Illuminate\Support\Carbon::parse($hotel->default_check_in_time)->format('H:i') }}",
                    checkOut: "{{ \Illuminate\Support\Carbon::parse($hotel->default_check_out_time)->format('H:i') }}",
                    cancellation: "{{ $hotel->cancellation_policy ?? '' }}",
                    pets: {{ $hotel->pets_allowed ? 'true' : 'false' }},
                    smoking: {{ $hotel->smoking_allowed ? 'true' : 'false' }}
                },
                amenities: {!! json_encode($optionalServices) !!},
                nearbyAttractions: [],
                contact: {
                    phone: "{{ $hotel->phone_number }}",
                    email: "{{ $hotel->contact_email }}",
                    website: "{{ $hotel->website }}"
                },
                rooms: {!! json_encode($hotel->roomTypes) !!}
            };

            return {
                hotel: hotel,
                selectedImageIndex: 0,
                tab: 'overview',
                checkIn: (new Date().toISOString().split('T')[0]),
                checkOut: '',
                guests: '2',
                selectedRoom: null,
                availabilityCount: 0,
                appliedRateType: '',
                appliedRate: 0,
                multiplier: 1,

                init() {
                    flatpickr("#checkInDate", {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: function(selectedDates, dateStr) {
                            const checkOutPicker = flatpickr("#checkOutDate");
                            checkOutPicker.set('minDate', selectedDates[0]);
                            if (selectedDates.length > 0) {
                                checkOutPicker.setDate(selectedDates[0], true);
                            }
                            if(this.selectedRoom) {
                                this.updateRoomRate(this.selectedRoom);
                            }
                        }
                    });

                    flatpickr("#checkOutDate", {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: function(selectedDates, dateStr) {
                            const checkInPicker = flatpickr("#checkInDate");
                            checkInPicker.set('maxDate', selectedDates[0]);
                            if(this.selectedRoom) {
                                this.updateRoomRate(this.selectedRoom);
                            }
                        }
                    });

                    this.$watch('selectedRoom', (newRoom) => {
                        this.updateRoomRate(newRoom);
                    });
                },

                get today() {
                    return new Date().toISOString().split('T')[0];
                },
                get nights() {
                    if (this.checkIn && this.checkOut) {
                        const checkIn = new Date(this.checkIn);
                        const checkOut = new Date(this.checkOut);
                        const timeDiff = checkOut.getTime() - checkIn.getTime();
                        const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                        return nights > 0 ? nights : 0;
                    }
                    return 0;
                },
                bookNow() {
                    if (this.selectedRoom && this.checkIn && this.checkOut) {
                        const params = new URLSearchParams({
                            hotelId: this.hotel.id,
                            roomTypeId: this.selectedRoom,
                            checkIn: this.checkIn,
                            checkOut: this.checkOut,
                            guests: this.guests
                        });

                        if ({{ auth()->check() ? 'true' : 'false' }}) {
                            window.location.href = `/reservations/create?${params.toString()}`;
                        } else {
                            params.append('redirect', window.location.href);
                            window.location.href = `/login?${params.toString()}`;
                        }
                    }
                },
                checkAvailability() {
                    const formData = new FormData();

                    formData.append('check_in', this.checkIn);
                    formData.append('check_out', this.checkOut);
                    formData.append('room_type_id', this.selectedRoom);

                    fetch(`/hotels/${this.hotel.id}/check-availability`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.available > 0) {
                                this.availabilityCount = data.available;
                                // alert('Selected room is available for the selected dates.');
                            } else {
                                this.availabilityCount = 0;
                                alert('Selected room is not available for the selected dates.');
                            }
                        })
                        .catch(error => {
                            this.availabilityCount = 0;
                            console.error('Error checking availability:', error);
                            alert('An error occurred while checking availability. Please try again later.');
                        });
                },

                updateRoomRate(selectedRoomId) {
                    const nights = this.nights;
                    const selectedRoom = this.hotel.rooms.find(r => r.id === selectedRoomId);
                    console.log(selectedRoom);
                    
                    if (selectedRoom.isSuite) {

                        if (nights >= 28) {
                            this.appliedRateType = 'Monthly';
                            this.appliedRate = selectedRoom.suiteMonthlyRate;
                            this.multiplier = Math.ceil(nights / 28);
                        } else {
                            this.appliedRateType = 'Weekly';
                            this.appliedRate = selectedRoom.suiteWeeklyRate;
                            this.multiplier = Math.ceil(nights / 7);
                        }
                    } else {
                        this.appliedRateType = 'Nightly';
                        this.appliedRate = selectedRoom.originalPrice;
                        this.multiplier = nights;
                    }

                },

                getAppliedRateText(appliedRateType) {
                    switch (appliedRateType) {
                        case 'Nightly':
                            return 'Nights';
                        case 'Weekly':
                            return 'Weeks';
                        case 'Monthly':
                            return 'Months';
                        default:
                            return 'Nights';
                    }
                },
            };
        }
    </script>
@endpush
