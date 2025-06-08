<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[85px] app-sidebar-minified' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-10 flex h-screen w-[290px] flex-col overflow-y-hidden border-r transition-all duration-300 ease-in-out {{ config('settings.sidebar_bg_lite') ? '' : 'bg-gray-800' }} dark:border-gray-900 dark:bg-gray-900 lg:static lg:translate-x-0"
    id="appSidebar" x-data="{
        isHovered: false,
        init() {
            this.updateBg();
            const observer = new MutationObserver(() => this.updateBg());
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

            // Check if sidebarToggle value is present in localStorage and use it
            if (localStorage.getItem('sidebarToggle')) {
                sidebarToggle = JSON.parse(localStorage.getItem('sidebarToggle'));
            }
        },
        updateBg() {
            const htmlHasDark = document.documentElement.classList.contains('dark');
            const liteBg = '{{ config('settings.sidebar_bg_lite') }}';
            const darkBg = '{{ config('settings.sidebar_bg_dark') }}';
            this.$el.style.backgroundColor = htmlHasDark ? darkBg : liteBg;
        }
    }" x-init="init()"
    @mouseenter="if(sidebarToggle) { isHovered = true; $el.classList.add('lg:w-[290px]'); $el.classList.remove('lg:w-[85px]', 'app-sidebar-minified'); }"
    @mouseleave="if(sidebarToggle) { isHovered = false; $el.classList.add('lg:w-[85px]', 'app-sidebar-minified'); $el.classList.remove('lg:w-[290px]'); }">
    <!-- Sidebar Header -->
    <div :class="sidebarToggle && !isHovered ? 'justify-center' : 'justify-between'"
        class="justify-center flex items-center gap-2 sidebar-header py-5 px-5 h-[100px] transition-all duration-300">
        <a href="{{ route('home') }}" class="group flex items-center space-x-3">
            <div class="relative">
                <div
                    class="w-10 h-10 dark:via-purple-600 dark:to-indigo-600  bg-gradient-to-tr from-blue-600 via-purple-600 to-indigo-600 rounded-xl shadow-lg rotate-12 group-hover:rotate-0 transition-transform duration-300">
                </div>
                <div
                    class="absolute inset-0 w-10 h-10 bg-gradient-to-tr from-blue-400 via-purple-400 to-indigo-400 rounded-xl blur-md opacity-70 -z-10">
                </div>
            </div>
            <span
                class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent dark:from-gray-100 dark:via-blue-300 dark:to-indigo-300 transition-colors duration-300">
                TravelEase
            </span>
        </a>
        {{-- <a href="{{ route('home') }}">
            <span class="logo transition-opacity duration-300" :class="sidebarToggle && !isHovered ? 'hidden opacity-0' : 'opacity-100'">
                <img
                    class="dark:hidden max-h-[80px]"
                    src="{{ config('settings.site_logo_lite') ?? asset('images/logo/lara-dashboard.png') }}"
                    alt="{{ config('app.name') }}"
                />
                <img
                    class="hidden dark:block max-h-[80px]"
                    src="{{ config('settings.site_logo_dark') ?? '/images/logo/lara-dashboard-dark.png' }}"
                    alt="{{ config('app.name') }}"
                />
            </span>
            <img
                class="logo-icon w-20 lg:w-12 transition-opacity duration-300"
                :class="sidebarToggle && !isHovered ? 'lg:block opacity-100' : 'hidden opacity-0'"
                src="{{ config('settings.site_icon') ?? '/images/logo/icon.png' }}"
                alt="{{ config('app.name') }}"
            />
        </a> --}}
    </div>
    <!-- End Sidebar Header -->

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        @include('backend.layouts.partials.sidebar-menu')
    </div>
</aside>
<!-- End Sidebar -->
