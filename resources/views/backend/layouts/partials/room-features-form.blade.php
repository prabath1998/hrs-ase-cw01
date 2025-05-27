@foreach ($predefinedFeatures as $key => $label)
    <div>
        <input class="mr-2" type="checkbox" name="features[{{ $key }}]"
            id="feature_{{ $key }}" value="1"
            {{ old('features.' . $key, isset($room) && isset($room->features[$key]) && $room->features[$key] ? '1' : '') == '1' ? 'checked' : '' }}>
        <label class="capitalize text-sm font-medium text-gray-700 dark:text-gray-400" for="feature_{{ $key }}">
            {{ $label }}
        </label>
    </div>
@endforeach
