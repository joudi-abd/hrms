@props([
    'type' => 'text',
    'name',
    'value' => '',
    'label' => null,
    'placeholder' => '',
])

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}" class="form-label block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="form-control @error($name) is-invalid @enderror"
        {{ $attributes->merge(['class' => 'block w-full shadow-sm sm:text-sm border-gray-300 rounded-md']) }}
    >

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>