@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Travel Company') }} - {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '{{ __('Edit Travel Company') }}' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Travel Company') }}</h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                            {{ __('Home') }}
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.travel-companies.index') }}">
                            {{ __('Travel Companies') }}
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Edit Travel Company') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Update Travel Company Information') }}</h3>
            </div>

            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                @include('backend.layouts.partials.messages')

                <form action="{{ route('admin.travel-companies.update', $travelCompany->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name" id="company_name" required value="{{ old('company_name', $travelCompany->company_name) }}" placeholder="{{ __('Enter Company Name') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Contact Person') }}</label>
                            <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $travelCompany->contact_name) }}" placeholder="{{ __('Enter Contact Person') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Contact Email') }}</label>
                            <input type="email" name="contact_email" id="contact_email" required value="{{ old('contact_email', $travelCompany->contact_email) }}" placeholder="{{ __('Enter Contact Email') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Phone Number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $travelCompany->phone_number) }}" placeholder="{{ __('Enter Phone Number') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div>
                            <label for="registration_number" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Registration Number') }}</label>
                            <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', $travelCompany->registration_number) }}" placeholder="{{ __('Enter Registration Number') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div>
                            <label for="negotiated_discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Negotiated Discount (%)') }}</label>
                            <input type="number" step="0.01" name="negotiated_discount_percentage" id="negotiated_discount_percentage" value="{{ old('negotiated_discount_percentage', $travelCompany->negotiated_discount_percentage) }}" placeholder="{{ __('Enter Discount') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div class="col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Address') }}</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $travelCompany->address) }}" placeholder="{{ __('Enter Address') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>

                        <div class="flex items-center mt-2">
                            <input type="hidden" name="is_approved" value="0">
                            <input type="checkbox" name="is_approved" id="is_approved" value="1"
                                class="h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-400 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-brand-500"
                                {{ old('is_approved', $travelCompany->is_approved) ? 'checked' : '' }}>
                            <label for="is_approved" class="ml-2 text-sm text-gray-700 dark:text-gray-400">{{ __('Is Approved') }}</label>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-start gap-4">
                        <button type="submit" class="btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('admin.travel-companies.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
