<header class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600">
                    HotelHub
                </a>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('hotels.index') }}"
                        class="text-gray-700 hover:text-blue-600 transition-colors">
                        Hotels
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                        Destinations
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                        Deals
                    </a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors">
                        About
                    </a>
                </nav>
            </div>
            <div class="flex items-center space-x-3">
                @guest
                    <a href="{{ route('admin.login') }}"
                        class="group relative px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-xl hover:bg-white hover:border-gray-300/80 hover:shadow-sm active:scale-[0.98] transition-all duration-200">
                        {{ __('Sign In') }}
                    </a>

                    <a href="{{ route('register') }}"
                        class="group relative px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 hover:shadow-lg hover:shadow-blue-500/25 active:scale-[0.98] transition-all duration-200 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        </div>
                        <span class="relative">{{ __('Register') }}</span>
                    </a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="group flex items-center space-x-3 px-4 py-2.5 bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl hover:bg-white hover:border-gray-300/80 hover:shadow-md active:scale-[0.98] transition-all duration-200">
                            <div class="relative">
                                <img class="w-9 h-9 rounded-full object-cover ring-2 ring-white shadow-sm"
                                    src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&bold=true' }}"
                                    alt="{{ auth()->user()->name }}">
                                <div
                                    class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full">
                                </div>
                            </div>

                            <div class="flex flex-col items-start min-w-0">
                                <span
                                    class="text-sm font-semibold text-gray-900 truncate max-w-32">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-gray-500">Online</span>
                            </div>

                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-all duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl border border-gray-200/60 rounded-2xl shadow-xl shadow-gray-900/10 z-50 overflow-hidden">

                            <div
                                class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/60">
                                <div class="flex items-center space-x-3">
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&bold=true' }}"
                                        alt="{{ auth()->user()->name }}">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="/admin"
                                    class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50/80 hover:text-gray-900 transition-all duration-150">
                                    <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">{{ __('Dashboard') }}</span>
                                </a>
                            </div>

                            <div class="border-t border-gray-200/60 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="group flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50/80 hover:text-red-700 transition-all duration-150">
                                        <svg class="w-4 h-4 mr-3 text-red-500 group-hover:text-red-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span class="font-medium">{{ __('Sign Out') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
