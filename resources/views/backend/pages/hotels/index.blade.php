@extends('backend.layouts.app')

@section('title')
    {{ __('Hotels') }} | {{ config('app.name') }}
@endsection


@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: {{ __('Hotels') }} }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Hotels') }}
                    @if (request('role'))
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                            {{ ucfirst(request('role')) }}
                        </span>
                    @endif
                </h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Hotels') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Hotels Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Hotels') }}</h3>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name or email'),
                    ])

                    @if (auth()->user()->can('hotel.create'))
                        <a href="{{ route('admin.hotels.create') }}" class="btn-primary">
                            <i class="bi bi-plus-circle mr-2"></i>
                            {{ __('New Hotel') }}
                        </a>
                    @endif
                </div>

                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                            <tr class="border-b border-gray-100 dark:border-gray-800 text-left">
                                <th class="p-3 px-5">{{ __('#') }}</th>
                                <th class="p-3 px-5">{{ __('Name') }}</th>
                                <th class="p-3 px-5">{{ __('Email') }}</th>
                                <th class="p-3 px-5">{{ __('Phone') }}</th>
                                <th class="p-3 px-5">{{ __('Address') }}</th>
                                <th class="p-3 px-5">{{ __('Check-in') }}</th>
                                <th class="p-3 px-5">{{ __('Check-out') }}</th>
                                <th class="p-3 px-5">{{ __('Status') }}</th>
                                <th class="p-3 px-5 text-center">{{ __('Action') }}</th>
                                <!-- Action should be centered -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hotels as $hotel)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">{{ $hotel->name }}</td>
                                    <td class="px-5 py-4">{{ $hotel->contact_email }}</td>
                                    <td class="px-5 py-4">{{ $hotel->phone_number }}</td>
                                    <td class="px-5 py-4">{{ $hotel->address }}</td>
                                    <td class="px-5 py-4">
                                        {{ \Carbon\Carbon::parse($hotel->default_check_in_time)->format('H:i') }}</td>
                                    <td class="px-5 py-4">
                                        {{ \Carbon\Carbon::parse($hotel->default_check_out_time)->format('H:i') }}</td>
                                    <td class="px-5 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $hotel->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $hotel->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn-default !p-3"
                                                title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Delete Button Trigger -->
                                            <a data-modal-target="delete-modal-{{ $hotel->id }}"
                                                data-modal-toggle="delete-modal-{{ $hotel->id }}"
                                                data-tooltip-target="tooltip-delete-hotel-{{ $hotel->id }}"
                                                class="btn-danger !p-3" href="javascript:void(0);">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>

                                            <!-- Tooltip -->
                                            <div id="tooltip-delete-hotel-{{ $hotel->id }}" role="tooltip"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Delete Hotel') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div id="delete-modal-{{ $hotel->id }}" tabindex="-1"
                                                class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                                <div
                                                    class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                                    <button type="button"
                                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="delete-modal-{{ $hotel->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">{{ __('Close modal') }}</span>
                                                    </button>
                                                    <div class="p-4 md:p-5 text-center">
                                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                        <h3
                                                            class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            {{ __('Are you sure you want to delete this hotel?') }}</h3>
                                                        <form action="{{ route('admin.hotels.destroy', $hotel->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                {{ __('Yes, Confirm') }}
                                                            </button>
                                                            <button data-modal-hide="delete-modal-{{ $hotel->id }}"
                                                                type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                                {{ __('No, cancel') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-gray-500">{{ __('No hotels found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <div class="my-4 px-4 sm:px-6">
                        {{ $hotels->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function handleRoleFilter(value) {
                let currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('role', value);
                window.location.href = currentUrl.toString();
            }
        </script>
    @endpush
@endsection
