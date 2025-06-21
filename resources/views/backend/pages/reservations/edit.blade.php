<form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="guest_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Guest Name') }}</label>
            <input type="text" name="guest_name" id="guest_name" required autofocus
                value="{{ old('guest_name', $reservation->guest_name) }}"
                placeholder="{{ __('Enter Guest Name') }}"
                class="dark:bg-dark-900 ...">
        </div>

        <div>
            <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Room') }}</label>
            <select name="room_id" id="room_id" required class="dark:bg-dark-900 ...">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="check_in" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Check-in Time') }}</label>
            <input type="datetime-local" name="check_in" id="check_in" required
                value="{{ old('check_in', $reservation->check_in ? $reservation->check_in->format('Y-m-d\TH:i') : '') }}"
                class="dark:bg-dark-900 ...">
        </div>

        <div>
            <label for="check_out" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Check-out Time') }}</label>
            <input type="datetime-local" name="check_out" id="check_out" required
                value="{{ old('check_out', $reservation->check_out ? $reservation->check_out->format('Y-m-d\TH:i') : '') }}"
                class="dark:bg-dark-900 ...">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Status') }}</label>
            <select name="status" id="status" required class="dark:bg-dark-900 ...">
                @foreach(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'checked_in' => 'Checked-in', 'checked_out' => 'Checked-out', 'cancelled' => 'Cancelled'] as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $reservation->status) == $key ? 'selected' : '' }}>
                        {{ __($label) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-6 flex justify-start gap-4">
        <button type="submit" class="btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.reservations.index') }}" class="btn-default">{{ __('Cancel') }}</a>
    </div>
</form>
