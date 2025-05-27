@extends('backend.layouts.app')

@section('title')
    {{ __('Room Type Create') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('New Room Type') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('New Room Type') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.room-types.index') }}">
                                {{ __('Room Types') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('New Room Type') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Create New Room Type') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.room-types.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2" x-data="{ suiteChecked: false }">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" required autofocus
                                    value="{{ old('name') }}" placeholder="{{ __('Enter Room Type Name') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Description') }}</label>
                                <input type="text" name="description" id="description" value="{{ old('description') }}"
                                    placeholder="{{ __('Enter Description') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="occupancy_limit"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Occupancy Limit') }}</label>
                                <input type="number" name="occupancy_limit" id="occupancy_limit" required
                                    value="{{ old('occupancy_limit') }}" placeholder="{{ __('Enter Occupancy Limit') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="base_price_per_night"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Base Price Per Night') }}</label>
                                <input type="number" name="base_price_per_night" id="base_price_per_night" required
                                    value="{{ old('base_price_per_night') }}"
                                    placeholder="{{ __('Enter Base Price Per Night') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div class="flex items-center mt-2 col-span-full">
                                <input type="checkbox" name="is_suite" id="is_suite" @change="suiteChecked = !suiteChecked"
                                    class="h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-400 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-brand-500"
                                    {{ old('is_suite', true) ? 'checked' : '' }}>
                                <label for="is_suite"
                                    class="ml-2 text-sm text-gray-700 dark:text-gray-400">{{ __('Is Suite?') }}</label>
                            </div>

                            <div x-show="!suiteChecked" x-transition>
                                <label for="suite_weekly_rate"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Suite Weekly Price') }}</label>
                                <input type="number" name="suite_weekly_rate" id="suite_weekly_rate"
                                    x-bind:disabled="suiteChecked" value="{{ old('suite_weekly_rate') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div x-show="!suiteChecked" x-transition>
                                <label for="suite_monthly_rate"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Suite Monthly Price') }}</label>
                                <input type="number" name="suite_monthly_rate" id="suite_monthly_rate"
                                    x-bind:disabled="suiteChecked" value="{{ old('suite_monthly_rate') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="is_active" id="is_active"
                                    class="h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-400 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-brand-500"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active"
                                    class="ml-2 text-sm text-gray-700 dark:text-gray-400">{{ __('Is Active') }}</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.room-types.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
