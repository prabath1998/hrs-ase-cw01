@extends('layouts.guest')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showFilters: false, sortBy: 'rating', priceRange: [0, 2000] }">
        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-3 text-gray-400"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                        <input type="text" placeholder="Search hotels, destinations, or landmarks..."
                            class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-4">
                    <select x-model="sortBy"
                        class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="rating">Highest Rated</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name">Name A-Z</option>
                    </select>
                    <button @click="showFilters = !showFilters"
                        class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filters
                    </button>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div x-show="showFilters" x-transition class="mt-6 pt-6 border-t grid md:grid-cols-4 gap-6">
                <div>
                    <h4 class="font-semibold mb-3">Price Range</h4>
                    <div class="space-y-3">
                        <input type="range" min="0" max="2000" step="50" x-model="priceRange[0]"
                            class="w-full">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>$<span x-text="priceRange[0]"></span></span>
                            <span>$2000</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-3">Star Rating</h4>
                    <select
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Any rating</option>
                        <option value="4.5">4.5+ stars</option>
                        <option value="4.0">4.0+ stars</option>
                        <option value="3.5">3.5+ stars</option>
                        <option value="3.0">3.0+ stars</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <h4 class="font-semibold mb-3">Amenities</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Free WiFi</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Swimming Pool</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Fitness Center</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Restaurant</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Spa</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded">
                            <span class="text-sm">Pet Friendly</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">6 hotels found</h2>
            <div class="text-sm text-gray-600">
                Showing 6 of 6 hotels
            </div>
        </div>

        <!-- Hotels Grid -->
        <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($hotels as $hotel)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                            alt="Grand Plaza Miami Beach"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-4 left-4 flex flex-col space-y-2">
                            <span class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                {{ __('Featured') }}
                            </span>
                            <span class="bg-yellow-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                {{ __('Save $50/night') }}
                            </span>
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

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <div class="text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm opacity-90">{{ __('Starting from') }}</p>
                                        <p class="text-2xl font-bold">${{ rand(100, 500) }}/night</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span
                                                class="ml-1 font-semibold">{{ number_format(rand(40, 50) / 10, 1) }}</span>
                                        </div>
                                        <p class="text-xs opacity-90">{{ rand(500, 3000) }} reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2">{{ $hotel->name }}</h3>
                            <div class="flex items-center text-gray-600 text-sm mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $hotel->address ?? 'City, Country' }}</span>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                {{ $hotel->description ?? 'Luxury hotel with premium amenities, prime location, and excellent services for a memorable stay.' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Free Wi-Fi</span>
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Breakfast Included</span>
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Swimming Pool</span>
                            <span class="border border-gray-200 text-gray-600 text-xs px-2 py-1 rounded">+5 more</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1 text-gray-400">
                                    <!-- Amenities icons -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zm14 5H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM2 10v2h2v-2H2zm0 4v1a1 1 0 001 1h1v-2H2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <a href="{{ route('hotels.show', ['hotel' => $hotel->id]) }}"
                                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                                {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-3 text-gray-500">{{ __('No hotels available.') }}</p>
            @endforelse
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Initialize date pickers
        flatpickr("#check-in", {
            dateFormat: "M d",
            minDate: "today"
        });

        flatpickr("#check-out", {
            dateFormat: "M d",
            minDate: "today"
        });
    </script>
@endpush
