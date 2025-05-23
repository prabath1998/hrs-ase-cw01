@php
    $menuService = app(\App\Services\MenuService\AdminMenuService::class);
    $menuGroups = $menuService->getMenu();
    $sidebarTextDark = config('settings.sidebar_text_dark', '#ffffff');
    $sidebarTextLite = config('settings.sidebar_text_lite', '#090909');
@endphp

<nav
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        textColor: '',
        init() {
            this.updateColor();
            const observer = new MutationObserver(() => this.updateColor());
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        },
        updateColor() {
            this.isDark = document.documentElement.classList.contains('dark');
            this.textColor = this.isDark ? '{{ $sidebarTextDark }}' : '{{ $sidebarTextLite }}';
        }
    }"
    x-init="init()"
    class="transition-all duration-300 ease-in-out"
>
    @foreach($menuGroups as $groupName => $groupItems)
        {!! ld_apply_filters('sidebar_menu_group_before_' . Str::slug($groupName), '') !!}
        <div>
            {!! ld_apply_filters('sidebar_menu_group_heading_before_' . Str::slug($groupName), '') !!}
            <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400 px-5">
                {{ __($groupName) }}
            </h3>
            {!! ld_apply_filters('sidebar_menu_group_heading_after_' . Str::slug($groupName), '') !!}
            <ul class="flex flex-col mb-6">
                {!! ld_apply_filters('sidebar_menu_before_all_' . Str::slug($groupName), '') !!}
                {!! $menuService->render($groupItems) !!}
                {!! ld_apply_filters('sidebar_menu_after_all_' . Str::slug($groupName), '') !!}
            </ul>
        </div>
        {!! ld_apply_filters('sidebar_menu_group_after_' . Str::slug($groupName), '') !!}
    @endforeach
</nav>
