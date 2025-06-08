<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }}</title>
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

<body class="bg-gray-50 min-h-screen" x-data="hotelPage()">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="/hotels" class="flex items-center px-2 py-1 rounded hover:bg-gray-100 text-blue-600">
                        <!-- ArrowLeft SVG -->
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Hotels
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">HotelHub</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="border px-3 py-1 rounded flex items-center text-gray-700 hover:bg-gray-100">
                        <!-- Share2 SVG -->
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <path d="M8.59 13.51l6.83 3.98" />
                            <path d="M15.41 6.51l-6.82 3.98" />
                        </svg>
                        Share
                    </button>
                    <button class="border px-3 py-1 rounded flex items-center text-gray-700 hover:bg-gray-100">
                        <!-- Heart SVG -->
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </header>

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
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all cursor-pointer">
                    </div>
                </div>
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <template x-for="(image, index) in hotel.images.slice(1, 5)" :key="index">
                        <div class="relative rounded-lg overflow-hidden cursor-pointer"
                            @click="selectedImageIndex = index + 1">
                            <img :src="image || '/placeholder.svg'" :alt="hotel.name + ' ' + (index + 2)"
                                class="object-cover w-full h-full absolute inset-0" />
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all">
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
                        <button :class="tab === 'overview' ? 'border-b-2 border-blue-600 font-bold' : ''"
                            class="py-2" @click="tab='overview'">Overview</button>
                        <button :class="tab === 'rooms' ? 'border-b-2 border-blue-600 font-bold' : ''"
                            class="py-2" @click="tab='rooms'">Rooms</button>
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
                                        <img :src="room.images[0] || '/placeholder.svg'" :alt="room.name"
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
                                                <template x-if="room.originalPrice">
                                                    <span class="text-sm text-gray-500 line-through"
                                                        x-text="'$' + room.originalPrice"></span>
                                                </template>
                                                <p class="text-2xl font-bold text-blue-600"
                                                    x-text="'$' + room.price + '/night'"></p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4 text-sm text-gray-600">
                                            <div x-text="'Size: ' + room.size"></div>
                                            <div x-text="'Max: ' + room.maxGuests + ' guests'"></div>
                                            <div x-text="'Bed: ' + room.bedType"></div>
                                            <div x-text="'Views: ' + room.views.join(', ')"></div>
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
                        <label class="block text-sm font-medium mb-2">Check-in Date</label>
                        <input type="date" class="w-full border rounded px-3 py-2" x-model="checkIn"
                            :min="today" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Check-out Date</label>
                        <input type="date" class="w-full border rounded px-3 py-2" x-model="checkOut"
                            :min="checkIn || today" />
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
                                <span x-text="nights + ' nights'"></span>
                            </div>
                            <template x-if="selectedRoom">
                                <div class="flex justify-between text-sm">
                                    <span>Room rate:</span>
                                    <span
                                        x-text="'$' + (hotel.rooms.find(r => r.id === selectedRoom)?.price) + '/night'"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                    <button class="w-full bg-blue-600 text-white py-2 rounded disabled:opacity-50"
                        :disabled="!checkIn || !checkOut || !selectedRoom" @click="bookNow">
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

    <script>
        function hotelPage() {
            // Example hotel data, replace with your own data source
            const hotel = {
                id: 1,
                name: "Sunset Galle Fort",
                rating: 4.7,
                reviewCount: 234,
                priceFrom: 120,
                description: "A beautiful hotel located in the heart of Galle Fort, offering stunning views and luxurious amenities.",
                address: "Galle City, Galle (Old Town)",
                images: [
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/83871748.jpg?k=1a0a78d60f129c5a6e29d1189ab6d9a174288ba270a4f9ff977b4d0a6977d58b&o=',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/84220869.jpg?k=d61f93267dc7680385f9898e3cf8e8eff91a99449192f7c63fa45e6364421277&o=&hp=1',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/86161620.jpg?k=08dc11fbb4e510d74712530d0b9f1b6b0b7c13923607279514ab27b2dabded97&o=&hp=1',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/86161663.jpg?k=ee5bd60f7ffdf9ff7b368dbd0e350dd61ab61baa7b503f531c8029febc64ff2b&o=&hp=1',
                ],
                features: ["Free WiFi", "Swimming Pool", "Spa & Wellness", "24/7 Reception"],
                awards: ["Best Luxury Hotel 2023"],
                sustainability: ["Solar Power", "Water Recycling"],
                policies: {
                    checkIn: "2:00 PM",
                    checkOut: "12:00 PM",
                    cancellation: "Free cancellation until 6 PM",
                    pets: true,
                    smoking: false
                },
                amenities: ["Restaurant", "Bar", "Gym", "Airport Shuttle", "Room Service", "Laundry"],
                nearbyAttractions: ["Central Park", "City Museum", "Shopping Mall"],
                contact: {
                    phone: "+94 91 222 3333",
                    email: "TlW4t@example.com",
                    website: "https://sunsetgallefort.com"
                },
                rooms: [{
                        id: 101,
                        name: "Standard Twin Room",
                        description: "Spacious room with 2 twin beds.",
                        images: [
                            "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80"
                        ],
                        price: 120,
                        originalPrice: 150,
                        size: "30m²",
                        maxGuests: 2,
                        bedType: "King",
                        views: ["City"],
                        amenities: ["WiFi", "TV", "Mini Bar"],
                        popularChoice: true,
                        lastBooked: "3 hours ago"
                    },
                    {
                        id: 102,
                        name: "Suite",
                        description: "Luxury suite with living area.",
                        images: [
                            "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80"
                        ],
                        price: 200,
                        size: "50m²",
                        maxGuests: 4,
                        bedType: "King",
                        views: ["City", "Park"],
                        amenities: ["WiFi", "TV", "Mini Bar", "Jacuzzi"],
                        popularChoice: false,
                        lastBooked: "1 day ago"
                    }
                ]
            };

            // Simulate getting hotel by id from URL
            const url = new URL(window.location.href);
            const id = Number(url.pathname.split("/").filter(Boolean).pop());
            const foundHotel = id === hotel.id ? hotel : null;

            return {
                hotel: foundHotel,
                selectedImageIndex: 0,
                tab: 'overview',
                checkIn: '',
                checkOut: '',
                guests: '2',
                selectedRoom: null,
                get today() {
                    return new Date().toISOString().split('T')[0];
                },
                get nights() {
                    if (this.checkIn && this.checkOut) {
                        const inDate = new Date(this.checkIn);
                        const outDate = new Date(this.checkOut);
                        const diff = (outDate - inDate) / (1000 * 60 * 60 * 24);
                        return diff > 0 ? diff : 0;
                    }
                    return 0;
                },
                bookNow() {
                    if (this.selectedRoom && this.checkIn && this.checkOut) {
                        const params = new URLSearchParams({
                            hotelId: this.hotel.id,
                            roomId: this.selectedRoom,
                            checkIn: this.checkIn,
                            checkOut: this.checkOut,
                            guests: this.guests
                        });
                        window.location.href = `/reservation?${params.toString()}`;
                    }
                }
            }
        }
    </script>
</body>

</html>
