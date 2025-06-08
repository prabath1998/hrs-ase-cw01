<header class="relative backdrop-blur-lg bg-white/70 border-b border-white/20 sticky top-0 z-50 shadow-lg shadow-black/5">
    <!-- Background gradient mesh -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-50/30 via-purple-50/20 to-indigo-50/30"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Section -->
            <div class="flex items-center space-x-8">
                <a href="{{ url('/') }}" class="group flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 via-purple-600 to-indigo-600 rounded-xl shadow-lg rotate-12 group-hover:rotate-0 transition-transform duration-300"></div>
                        <div class="absolute inset-0 w-10 h-10 bg-gradient-to-tr from-blue-400 via-purple-400 to-indigo-400 rounded-xl blur-md opacity-70 -z-10"></div>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
                        TravelEase
                    </span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-1">
                    <a href="{{ route('hotels.index') }}" class="group relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-all duration-300">
                        <span class="relative z-10">Hotels</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    </a>
                    <a href="#" class="group relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-all duration-300">
                        <span class="relative z-10">Destinations</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    </a>
                    <a href="#" class="group relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-all duration-300">
                        <span class="relative z-10">Deals</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    </a>
                    <a href="#" class="group relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-all duration-300">
                        <span class="relative z-10">About</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-300"></div>
                    </a>
                </nav>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-3">
                @guest
                    <a href="{{ route('admin.login') }}" class="group relative px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white/60 backdrop-blur-sm border border-white/30 rounded-2xl hover:bg-white/80 hover:border-white/50 hover:shadow-lg active:scale-95 transition-all duration-200">
                        <span class="relative z-10">{{ __('Sign In') }}</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-white/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>

                    <a href="{{ route('register') }}" class="group relative px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-500/25 active:scale-95 transition-all duration-200 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 via-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        <span class="relative z-10">{{ __('Register') }}</span>
                    </a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="group flex items-center space-x-3 px-4 py-3 bg-white/60 backdrop-blur-sm border border-white/30 rounded-2xl hover:bg-white/80 hover:border-white/50 hover:shadow-lg active:scale-95 transition-all duration-200">
                            <div class="relative">
                                <img class="w-10 h-10 rounded-full object-cover ring-2 ring-white/50 shadow-lg"
                                     src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&bold=true' }}"
                                     alt="{{ auth()->user()->name }}">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full shadow-sm"></div>
                            </div>

                            <div class="flex flex-col items-start min-w-0">
                                <span class="text-sm font-semibold text-gray-900 truncate max-w-32">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-emerald-600 font-medium">Online</span>
                            </div>

                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-all duration-200"
                                 :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                             class="absolute right-0 mt-3 w-72 bg-white/90 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl shadow-gray-900/20 z-50 overflow-hidden">

                            <!-- Profile Header -->
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50/80 to-blue-50/80 border-b border-white/30">
                                <div class="flex items-center space-x-4">
                                    <img class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-lg"
                                         src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&bold=true' }}"
                                         alt="{{ auth()->user()->name }}">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="/admin" class="group flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-all duration-150">
                                    <div class="w-8 h-8 bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:from-blue-200 group-hover:to-indigo-200 transition-all duration-150">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ __('Dashboard') }}</span>
                                </a>
                            </div>

                            <!-- Logout Section -->
                            <div class="border-t border-white/30 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group flex items-center w-full px-6 py-3 text-sm text-red-600 hover:bg-red-50/80 hover:text-red-700 transition-all duration-150">
                                        <div class="w-8 h-8 bg-gradient-to-tr from-red-100 to-pink-100 rounded-lg flex items-center justify-center mr-3 group-hover:from-red-200 group-hover:to-pink-200 transition-all duration-150">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ __('Sign Out') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button class="md:hidden group relative p-2 bg-white/60 backdrop-blur-sm border border-white/30 rounded-xl hover:bg-white/80 transition-all duration-200">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
