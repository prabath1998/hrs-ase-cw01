<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Hotel - Premium Accommodations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                        'gold-light': '#F4E4BC',
                        'gold-dark': '#B8941F'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Luxe Hotel</h1>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-gold transition-colors">Home</a>
                    <a href="#rooms" class="text-gray-700 hover:text-gold transition-colors">Rooms</a>
                    <a href="#amenities" class="text-gray-700 hover:text-gold transition-colors">Amenities</a>
                    <a href="#about" class="text-gray-700 hover:text-gold transition-colors">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-gold transition-colors">Contact</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.login') }}"
                                class="text-slate-600 hover:text-slate-900 font-medium px-4 py-2 rounded-full transition-all duration-200 hover:bg-slate-50">
                                {{ __('Login') }}
                            </a>
                            <a href="{{ route('register') }}"
                                class="bg-slate-900 text-white hover:bg-slate-800 font-medium px-6 py-2 rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                                {{ __('Register') }}
                            </a>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">

                            <div
                                class="flex items-center space-x-3 bg-white rounded-full px-4 py-2 shadow-sm border border-slate-200 hover:shadow-md transition-all duration-200">
                                <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0f172a&color=ffffff' }}"
                                    alt="{{ Auth::user()->name }}" class="w-7 h-7 rounded-full ring-2 ring-slate-100">

                                <span class="text-slate-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                            </div>


                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-slate-500 hover:text-slate-700 p-2 rounded-full hover:bg-slate-100 transition-all duration-200 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>


                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="#home" class="text-gray-700 hover:text-gold transition-colors">Home</a>
                    <a href="#rooms" class="text-gray-700 hover:text-gold transition-colors">Rooms</a>
                    <a href="#amenities" class="text-gray-700 hover:text-gold transition-colors">Amenities</a>
                    <a href="#about" class="text-gray-700 hover:text-gold transition-colors">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-gold transition-colors">Contact</a>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex flex-col space-y-3">
                            <button
                                class="text-gray-700 hover:text-gold transition-colors px-4 py-2 rounded-lg hover:bg-gray-50 text-left">
                                Login
                            </button>
                            <button
                                class="text-gray-700 hover:text-gold transition-colors px-4 py-2 rounded-lg hover:bg-gray-50 border border-gray-300 text-left">
                                Register
                            </button>
                            <button
                                class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-gold-dark transition-colors">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen bg-cover bg-center"
        style="background-image: url('/placeholder.svg?height=800&width=1200');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative container mx-auto px-4 h-full flex items-center">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-5xl md:text-7xl font-bold mb-6">Experience Luxury</h2>
                <p class="text-xl md:text-2xl mb-8">Discover unparalleled comfort and elegance at Luxe Hotel</p>

                <!-- Booking Form -->
                <div class="bg-white bg-opacity-95 rounded-lg p-6 md:p-8 text-gray-800 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold mb-6 text-center">Reserve Your Stay</h3>
                    <form class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="lg:col-span-1">
                            <label for="checkin" class="block text-sm font-medium mb-2">Check-in</label>
                            <input type="date" id="checkin"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                        </div>
                        <div class="lg:col-span-1">
                            <label for="checkout" class="block text-sm font-medium mb-2">Check-out</label>
                            <input type="date" id="checkout"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                        </div>
                        <div class="lg:col-span-1">
                            <label for="guests" class="block text-sm font-medium mb-2">Guests</label>
                            <select id="guests"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                                <option>1 Guest</option>
                                <option>2 Guests</option>
                                <option>3 Guests</option>
                                <option>4 Guests</option>
                                <option>5+ Guests</option>
                            </select>
                        </div>
                        <div class="lg:col-span-1">
                            <label for="room-type" class="block text-sm font-medium mb-2">Room Type</label>
                            <select id="room-type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                                <option>Standard Room</option>
                                <option>Deluxe Room</option>
                                <option>Suite</option>
                                <option>Presidential Suite</option>
                            </select>
                        </div>
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-medium mb-2">&nbsp;</label>
                            <button type="submit"
                                class="w-full bg-gold text-white py-2 px-4 rounded-lg hover:bg-gold-dark transition-colors font-semibold">
                                Search Rooms
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Rooms -->
    <section id="rooms" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Rooms & Suites</h2>
                <p class="text-xl text-gray-600">Choose from our selection of luxurious accommodations</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Standard Room -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=250&width=400" alt="Standard Room"
                        class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">Standard Room</h3>
                        <p class="text-gray-600 mb-4">Comfortable and elegant room with modern amenities</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-3xl font-bold text-gold">$199</span>
                            <span class="text-gray-500">per night</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                            <li>• King size bed</li>
                            <li>• City view</li>
                            <li>• Free WiFi</li>
                            <li>• 24/7 room service</li>
                        </ul>
                        <button class="w-full bg-gold text-white py-2 rounded-lg hover:bg-gold-dark transition-colors">
                            Book Now
                        </button>
                    </div>
                </div>

                <!-- Deluxe Room -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=250&width=400" alt="Deluxe Room"
                        class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">Deluxe Room</h3>
                        <p class="text-gray-600 mb-4">Spacious room with premium furnishings and amenities</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-3xl font-bold text-gold">$299</span>
                            <span class="text-gray-500">per night</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                            <li>• King size bed</li>
                            <li>• Ocean view</li>
                            <li>• Mini bar</li>
                            <li>• Marble bathroom</li>
                        </ul>
                        <button class="w-full bg-gold text-white py-2 rounded-lg hover:bg-gold-dark transition-colors">
                            Book Now
                        </button>
                    </div>
                </div>

                <!-- Presidential Suite -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="/placeholder.svg?height=250&width=400" alt="Presidential Suite"
                        class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">Presidential Suite</h3>
                        <p class="text-gray-600 mb-4">Ultimate luxury with panoramic views and exclusive services</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-3xl font-bold text-gold">$799</span>
                            <span class="text-gray-500">per night</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                            <li>• Separate living area</li>
                            <li>• Panoramic view</li>
                            <li>• Butler service</li>
                            <li>• Private balcony</li>
                        </ul>
                        <button class="w-full bg-gold text-white py-2 rounded-lg hover:bg-gold-dark transition-colors">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities -->
    <section id="amenities" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">World-Class Amenities</h2>
                <p class="text-xl text-gray-600">Everything you need for a perfect stay</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Spa & Wellness</h3>
                    <p class="text-gray-600">Rejuvenate with our full-service spa and wellness center</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Prime Location</h3>
                    <p class="text-gray-600">Located in the heart of the city with easy access to attractions</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">24/7 Concierge</h3>
                    <p class="text-gray-600">Round-the-clock personalized service for all your needs</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Fine Dining</h3>
                    <p class="text-gray-600">Award-winning restaurants with world-class cuisine</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">About Luxe Hotel</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        For over three decades, Luxe Hotel has been synonymous with exceptional hospitality and
                        unparalleled luxury.
                        Our commitment to excellence has made us a preferred destination for discerning travelers from
                        around the world.
                    </p>
                    <p class="text-lg text-gray-600 mb-8">
                        From our elegantly appointed rooms to our world-class amenities, every detail has been carefully
                        crafted
                        to ensure your stay exceeds expectations. Experience the perfect blend of comfort,
                        sophistication, and personalized service.
                    </p>
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-gold mb-2">30+</div>
                            <div class="text-gray-600">Years of Excellence</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gold mb-2">500+</div>
                            <div class="text-gray-600">Luxury Rooms</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gold mb-2">98%</div>
                            <div class="text-gray-600">Guest Satisfaction</div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="/placeholder.svg?height=500&width=600" alt="Hotel Lobby" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Contact Us</h2>
                <p class="text-xl text-gray-600">Get in touch for reservations and inquiries</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <div class="space-y-8">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gold-light rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Address</h3>
                                <p class="text-gray-600">123 Luxury Avenue<br>Downtown District<br>New York, NY 10001
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gold-light rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Phone</h3>
                                <p class="text-gray-600">+1 (555) 123-4567<br>Reservations: +1 (555) 123-4568</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gold-light rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Email</h3>
                                <p class="text-gray-600">info@luxehotel.com<br>reservations@luxehotel.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">First
                                    Name</label>
                                <input type="text" id="first-name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">Last
                                    Name</label>
                                <input type="text" id="last-name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-gold text-white py-3 px-6 rounded-lg hover:bg-gold-dark transition-colors font-semibold">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">L</span>
                        </div>
                        <h3 class="text-2xl font-bold">Luxe Hotel</h3>
                    </div>
                    <p class="text-gray-400">Experience unparalleled luxury and comfort at our world-class hotel.</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#home" class="hover:text-gold transition-colors">Home</a></li>
                        <li><a href="#rooms" class="hover:text-gold transition-colors">Rooms</a></li>
                        <li><a href="#amenities" class="hover:text-gold transition-colors">Amenities</a></li>
                        <li><a href="#about" class="hover:text-gold transition-colors">About</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-gold transition-colors">Room Service</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Spa & Wellness</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Fine Dining</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Event Planning</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gold transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gold transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gold transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Luxe Hotel. All rights reserved. | Privacy Policy | Terms of Service</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Set minimum date for check-in to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkin').setAttribute('min', today);

        // Update check-out minimum date when check-in changes
        document.getElementById('checkin').addEventListener('change', function() {
            const checkinDate = new Date(this.value);
            checkinDate.setDate(checkinDate.getDate() + 1);
            const minCheckout = checkinDate.toISOString().split('T')[0];
            document.getElementById('checkout').setAttribute('min', minCheckout);
        });
    </script>
</body>

</html>
