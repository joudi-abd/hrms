@props([
    'name',
    'label' => null,
    'placeholder' => '',
    'options' => [],
    'selected' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="form-label block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        class="form-select @error($name) is-invalid @enderror"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" {{ old($name , $selected) == $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>