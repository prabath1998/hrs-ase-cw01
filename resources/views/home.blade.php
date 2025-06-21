@extends('layouts.guest')

@push('styles')
    <style>
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ asset('images/hotel/grand-plaza-miami.jpg') }});
            background-size: cover;
            background-position: center;
        }

        .special-offers {
            background: linear-gradient(to right, #2563eb, #7c3aed);
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section with Search -->
    <section class="hero-section relative h-[600px] flex items-center justify-center">
        <div class="relative z-10 text-center text-white max-w-6xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Find Your Perfect Stay</h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-200">
                Discover amazing hotels, resorts, and unique accommodations worldwide
            </p>

            <!-- Search Form -->
            <div class="bg-white text-gray-900 p-6 rounded-lg shadow-xl max-w-4xl mx-auto" x-data="hotelSearchForm()">
                <div class="grid md:grid-cols-5 gap-4">

                    <div class="md:col-span-2">
                        <label for="destination" class="block text-sm font-medium mb-2">Where are you going?</label>
                        <div class="relative">
                            <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)"
                                class="h-5 w-5 absolute left-3 top-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <input id="destination" type="text" placeholder="Destination, hotel name..."
                                class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                x-model="destination">
                        </div>
                    </div>

                    <div>
                        <label for="check-in" class="block text-sm font-medium mb-2">Check-in</label>
                        <input type="text" id="check-in" placeholder="Add dates"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            x-ref="checkin">
                    </div>

                    <div>
                        <label for="check-out" class="block text-sm font-medium mb-2">Check-out</label>
                        <input type="text" id="check-out" placeholder="Add dates"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            x-ref="checkout">
                    </div>

                    <div>
                        <label for="guests" class="block text-sm font-medium mb-2">Guests</label>
                        <select id="guests"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            x-model="guests">
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5+ Guests</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end items-center mt-6">
                    <button @click="performSearch()"
                        class="px-8 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 flex items-center">
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-5 w-5 mr-2"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                        Search Hotels
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Searches -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4 text-sm overflow-x-auto">
                <span class="text-gray-600 whitespace-nowrap">Popular searches:</span>
                <div class="flex flex-wrap gap-2">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                        Miami Beach • Mar 15-18 • 2 guests
                    </button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                        New York City • Apr 20-23 • 1 guest
                    </button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                        Aspen • Feb 10-14 • 4 guests
                    </button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 whitespace-nowrap">
                        Malibu • May 5-8 • 2 guests
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="special-offers py-12 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-2">Special Offers</h2>
                <p class="text-blue-100">Limited time deals you don't want to miss</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"
                                clip-rule="evenodd" />
                            <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z" />
                        </svg>
                        <span class="bg-yellow-500 text-yellow-900 px-2 py-1 rounded text-xs font-semibold">25%
                            OFF</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Early Bird Special</h3>
                    <p class="text-blue-100 mb-4">Book 30 days in advance and save up to 25%</p>
                    <div class="flex justify-between items-center text-sm">
                        <span>Valid until 2024-12-31</span>
                        <button
                            class="px-3 py-1 border border-white rounded-md text-white hover:bg-white hover:text-blue-600 transition-colors">
                            Learn More
                        </button>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"
                                clip-rule="evenodd" />
                            <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z" />
                        </svg>
                        <span class="bg-yellow-500 text-yellow-900 px-2 py-1 rounded text-xs font-semibold">Free
                            Night</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Extended Stay Discount</h3>
                    <p class="text-blue-100 mb-4">Stay 7+ nights and get the 8th night free</p>
                    <div class="flex justify-between items-center text-sm">
                        <span>Valid until 2024-11-30</span>
                        <button
                            class="px-3 py-1 border border-white rounded-md text-white hover:bg-white hover:text-blue-600 transition-colors">
                            Learn More
                        </button>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"
                                clip-rule="evenodd" />
                            <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z" />
                        </svg>
                        <span class="bg-yellow-500 text-yellow-900 px-2 py-1 rounded text-xs font-semibold">20%
                            OFF</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Weekend Getaway</h3>
                    <p class="text-blue-100 mb-4">Special rates for Friday-Sunday stays</p>
                    <div class="flex justify-between items-center text-sm">
                        <span>Valid until 2024-10-31</span>
                        <button
                            class="px-3 py-1 border border-white rounded-md text-white hover:bg-white hover:text-blue-600 transition-colors">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Hotels -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Hotels</h2>
                <p class="text-xl text-gray-600">Handpicked luxury accommodations for unforgettable experiences</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Hotel Card 1 -->
                @foreach ($hotels as $hotel)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ json_decode($hotel->images)[0] }}"
                                alt="{{ $hotel->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white text-gray-900 px-2 py-1 rounded text-xs font-semibold">Featured</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/80 hover:bg-white p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-600">Starting from</p>
                                            <p class="text-xl font-bold">${{ $hotel->minimumPrice() }}/night</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span class="ml-1 font-semibold">{{ $hotel->rating }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600">{{ rand(500, 3000) }} reviews</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-3">
                                <h3 class="text-xl font-bold mb-1">{{ $hotel->name }}</h3>
                                <div class="flex items-center text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $hotel->address }}</span>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $hotel->description }}</p>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Private Beach</span>
                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Spa</span>
                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Pool</span>
                                <span class="border border-gray-200 text-gray-600 text-xs px-2 py-1 rounded">+9 more</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-gray-600 ml-1">Award Winner</span>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

            <div class="text-center mt-12">
                <a href="{{ route('hotels.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center">
                    View All Hotels
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Partner With Us Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Partner With Us</h2>
                <p class="text-xl text-gray-600">
                    Grow your business by joining the TravelEase network and offering our extensive inventory to your
                    clients.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                        alt="Partner Hotels" class="rounded-lg shadow-lg">
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-4">Unlock New Opportunities</h3>
                    <p class="text-gray-600 mb-4">
                        Join our partner program and gain access to competitive commission rates, marketing support, and
                        advanced booking management tools.
                    </p>
                    <ul class="list-disc list-inside text-gray-600 mb-6">
                        <li>Competitive commission rates</li>
                        <li>Marketing support and co-branding opportunities</li>
                        <li>24/7 partner support</li>
                        <li>Advanced booking management tools</li>
                        <li>Real-time inventory access</li>
                        <li>Flexible payment terms</li>
                    </ul>
                    <a href="{{ route('travel-company.register') }}"
                        class="px-6 py-3 bg-blue-600 border border-transparent rounded-md text-base font-medium text-white hover:bg-blue-700">
                        Become a Partner
                    </a>
                </div>
            </div>

            <div class="mt-12 grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mx-auto mb-2"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-2xl font-bold text-gray-900">15%</p>
                    <p class="text-gray-600">Average Commission</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mx-auto mb-2"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1.581.814L10 13.197l-4.419 2.617A1 1 0 014 15V4zm2-1a1 1 0 00-1 1v10.566l3.419-2.021a1 1 0 011.162 0L13 14.566V4a1 1 0 00-1-1H6z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-2xl font-bold text-gray-900">5,000+</p>
                    <p class="text-gray-600">Partner Hotels</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-600 mx-auto mb-2"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-2xl font-bold text-gray-900">120+</p>
                    <p class="text-gray-600">Countries Covered</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated with Exclusive Deals</h2>
            <p class="text-xl mb-8 text-blue-100">
                Subscribe to our newsletter and be the first to know about special offers
            </p>
            <div class="max-w-md mx-auto flex space-x-4">
                <input type="email" placeholder="Enter your email address"
                    class="flex-1 px-4 py-2 rounded-md text-gray-900">
                <button class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-yellow-900 font-semibold rounded-md">
                    Subscribe
                </button>
            </div>
            <p class="text-sm text-blue-200 mt-4">No spam, unsubscribe at any time</p>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        function hotelSearchForm() {
            return {
                destination: '',
                checkin: '',
                checkout: '',
                guests: 2,

                init() {
                    const fpIn = flatpickr(this.$refs.checkin, {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: (selectedDates) => {
                            this.checkin = selectedDates[0] ? this.formatDate(selectedDates[0]) : '';
                            if (this.checkin) {
                                fpOut.set('minDate', new Date(this.checkin).fp_incr(1));
                            }
                        },
                    });

                    const fpOut = flatpickr(this.$refs.checkout, {
                        dateFormat: "Y-m-d",
                    });
                },

                formatDate(date) {

                    let d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                    if (month.length < 2)
                        month = '0' + month;
                    if (day.length < 2)
                        day = '0' + day;

                    return [year, month, day].join('-');
                },

                performSearch() {
                    const baseUrl = "{{ route('hotels.index') }}";

                    const params = new URLSearchParams();
                    if (this.destination) params.append('destination', this.destination);
                    if (this.checkin) params.append('checkin', this.checkin);
                    if (this.checkout) params.append('checkout', this.checkout);
                    if (this.guests) params.append('guests', this.guests);

                    window.location.href = `${baseUrl}?${params.toString()}`;
                }
            }
        }
    </script>
@endpush
