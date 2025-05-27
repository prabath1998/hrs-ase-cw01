@extends('backend.layouts.app')

@section('title')
    {{ __('Rooms') }} | {{ config('app.name') }}
@endsection


@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Rooms') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Rooms') }}
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Rooms') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Room Types Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Rooms') }}</h3>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name or email'),
                    ])

                    @if (auth()->user()->can('room.manage'))
                        <a href="{{ route('admin.rooms.create') }}" class="btn-primary">
                            <i class="bi bi-plus-circle mr-2"></i>
                            {{ __('New Room') }}
                        </a>
                    @endif
                </div>

                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="p-2 px-5">{{ __('#') }}</th>
                                <th class="p-2 px-5">{{ __('Room Number') }}</th>
                                <th class="p-2 px-5">{{ __('Floor') }}</th>
                                <th class="p-2 px-5">{{ __('Room Type') }}</th>
                                <th class="p-2 px-5">{{ __('Hotel') }}</th>
                                <th class="p-2 px-5">{{ __('Features') }}</th>
                                <th class="p-2 px-5">{{ __('Status') }}</th>
                                <th class="p-2 px-5">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rooms as $room)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">{{ $room->room_number }}</td>
                                    <td class="px-5 py-4">{{ $room->floor ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $room->roomType->name }}</td>
                                    <td class="px-5 py-4">{{ $room->hotel->name }}</td>
                                    <td class="px-5 py-4">
                                        @foreach ($room->features ?? [] as $key => $value)
                                            @if (!$value)
                                                @continue
                                            @endif
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                                                {{ $value ? ucwords(preg_replace('/_/', ' ', $key)) : '' }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $statusClasses = [
                                                'available' => 'bg-green-100 text-green-800',
                                                'occupied' => 'bg-red-100 text-red-800',
                                                'maintenance' => 'bg-yellow-100 text-yellow-800',
                                                'blocked' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusClass = $statusClasses[$room->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn-default !p-3"
                                                title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Delete Button Trigger -->
                                            <a data-modal-target="delete-modal-{{ $room->id }}"
                                                data-modal-toggle="delete-modal-{{ $room->id }}"
                                                data-tooltip-target="tooltip-delete-hotel-{{ $room->id }}"
                                                class="btn-danger !p-3" href="javascript:void(0);">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>

                                            <!-- Tooltip -->
                                            <div id="tooltip-delete-room-{{ $room->id }}" role="tooltip"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                {{ __('Delete Room') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div id="delete-modal-{{ $room->id }}" tabindex="-1"
                                                class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                                <div
                                                    class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                                    <button type="button"
                                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="delete-modal-{{ $room->id }}">
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
                                                            {{ __('Are you sure you want to delete this room?') }}
                                                        </h3>
                                                        <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                {{ __('Yes, Confirm') }}
                                                            </button>
                                                            <button data-modal-hide="delete-modal-{{ $room->id }}"
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
                                    <td colspan="9" class="text-center py-4 text-gray-500">
                                        {{ __('No rooms found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $rooms->links() }}
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
