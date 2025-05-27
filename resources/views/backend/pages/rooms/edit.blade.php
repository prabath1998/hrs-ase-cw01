@extends('backend.layouts.app')

@section('title')
    {{ __('Room Edit') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Edit Room') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Room') }}</h2>
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
                                href="{{ route('admin.rooms.index') }}">
                                {{ __('Rooms') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Edit Room') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        {{ __('Update Room Information') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Hotel') }}
                                </label>
                                <select name="hotel_id" id="hotel_id" required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" disabled selected>{{ __('Select Hotel') }}</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}"
                                            {{ $hotel->id == $room->hotel_id ? 'selected' : '' }}>
                                            {{ $hotel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="room_type_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Room Type') }}
                                </label>
                                <select name="room_type_id" id="room_type_id" required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" disabled selected>{{ __('Select Room Type') }}</option>
                                    @foreach ($roomTypes as $roomType)
                                        <option value="{{ $roomType->id }}"
                                            {{ $roomType->id == $room->room_type_id ? 'selected' : '' }}>
                                            {{ $roomType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="room_number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Room Number') }}</label>
                                <input type="text" name="room_number" id="room_number" required autofocus
                                    value="{{ $room->room_number }}" placeholder="{{ __('Enter Room Number') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="floor"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Floor Number') }}</label>
                                <input type="number" name="floor" id="floor" value="{{ $room->floor }}"
                                    placeholder="{{ __('Enter Floor Number') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Status') }}
                                </label>
                                <select name="status" id="status" required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" disabled selected>{{ __('Room Status') }}</option>
                                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>
                                        {{ __('Available') }}</option>
                                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>
                                        {{ __('Occupied') }}</option>
                                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>
                                        {{ __('Maintenance') }}</option>
                                    <option value="blocked" {{ $room->status == 'blocked' ? 'selected' : '' }}>
                                        {{ __('Blocked') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="features" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Features') }}
                                </label>
                                <div class="flex flex-wrap gap-4">
                                    @include('backend.layouts.partials.room-features-form', [
                                        'predefinedFeatures' => $predefinedFeatures,
                                        'room' => $room ?? null,
                                    ])
                                </div>
                            </div>

                            <div class="mt-6 flex justify-start gap-4">
                                <button type="submit" class="btn-primary">{{ __('Update') }}</button>
                                <a href="{{ route('admin.rooms.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
