@extends('backend.layouts.app')

@section('title')
    {{ __('Dashboard') }} | {{ config('app.name') }}
@endsection

@section('before_vite_build')
    <script>
        var userGrowthData = @json($user_growth_data['data']);
        var userGrowthLabels = @json($user_growth_data['labels']);
    </script>
    <script>
        var billingLabels = @json($billing_months);
        var billingData = @json($billing_totals);
    </script>

@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Dashboard') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Dashboard') }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-4 md:gap-6">
                    @include('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/user.svg'),
                        'label' => __('Users'),
                        'value' => $total_users,
                        'bg' => '#635BFF',
                        'class' => 'bg-white',
                        'url' => route('admin.users.index'),
                    ])
                    @include('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/key.svg'),
                        'label' => __('Hotels'),
                        'value' => $total_hotels,
                        'bg' => '#00D7FF',
                        'class' => 'bg-white',
                        'url' => route('admin.roles.index'),
                    ])
                    @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-shield-check',
                        'label' => __('Travel Companies'),
                        'value' => $total_travel_companies,
                        'bg' => '#FF4D96',
                        'class' => 'bg-white',
                        'url' => route('admin.permissions.index'),
                    ])
                    {{-- @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-translate',
                        'label' => __('Translations'),
                        'value' => $languages['total'] . ' / ' . $languages['active'],
                        'bg' => '#22C55E',
                        'class' => 'bg-white',
                        'url' => route('admin.translations.index'),
                    ]) --}}
                    @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-receipt',
                        'label' => __('Bills'),
                        'value' => $total_bills,
                        'bg' => '#3B82F6',
                        'class' => 'bg-white',
                        // 'url' => route('admin.bills.index'),
                    ])
                    {{-- @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-cash-coin',
                        'label' => __('Total Paid'),
                        'value' => '$' . $total_paid,
                        'bg' => '#10B981',
                        'class' => 'bg-white',
                        // 'url' => route('admin.bills.index'),
                    ]) --}}
                    {{-- @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-exclamation-circle',
                        'label' => __('Unpaid Amount'),
                        'value' => '$' . $total_unpaid,
                        'bg' => '#EF4444',
                        'class' => 'bg-white',
                        // 'url' => route('admin.bills.index'),
                    ]) --}}
                    {{-- @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-percent',
                        'label' => __('Avg. Discount'),
                        'value' => $average_discount . '%',
                        'bg' => '#F59E0B',
                        'class' => 'bg-white',
                        // 'url' => route('admin.bills.index'),
                    ]) --}}

                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
                <div class="col-span-12 md:col-span-8">
                    @include('backend.pages.dashboard.partials.user-growth')
                </div>

                <div class="col-span-12 md:col-span-4">
                    @include('backend.pages.dashboard.partials.user-history')
                </div>

                <div class="col-span-12 lg:col-span-12">
                    @include('backend.pages.dashboard.partials.billing-chart')
                </div>

                {{-- <div class="col-span-12 lg:col-span-6">
                    @include('backend.pages.dashboard.partials.payment-status-chart')
                </div> --}}
            </div>
        </div>

    </div>
@endsection
