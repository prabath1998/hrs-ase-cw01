@extends('backend.layouts.app')

@section('title')
    {{ __('Hotels') }} | {{ config('app.name') }}
@endsection


@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: {{ __('Users') }} }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Users') }}
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Users') }}</li>
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
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="p-2 px-5">{{ __('#') }}</th>
                                <th class="p-2 px-5">{{ __('Name') }}</th>
                                <th class="p-2 px-5">{{ __('Email') }}</th>
                                <th class="p-2 px-5">{{ __('Phone') }}</th>
                                <th class="p-2 px-5">{{ __('Address') }}</th>
                                <th class="p-2 px-5">{{ __('Check-in') }}</th>
                                <th class="p-2 px-5">{{ __('Check-out') }}</th>
                                <th class="p-2 px-5">{{ __('Status') }}</th>
                                <th class="p-2 px-5">{{ __('Action') }}</th>
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
                                    <td class="px-5 py-4">{{ \Carbon\Carbon::parse($hotel->default_check_in_time)->format('H:i') }}</td>
                                    <td class="px-5 py-4">{{ \Carbon\Carbon::parse($hotel->default_check_out_time)->format('H:i') }}</td>
                                    <td class="px-5 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $hotel->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $hotel->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 flex gap-2">
                                        <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn-default !p-3"
                                            title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger !p-3" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
