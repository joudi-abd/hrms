@props([
    'name',
    'label' => null,
    'value' => null,
    'rows' => 4,
    'cols' => 50,
    'placeholder' => '',
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        rows="{{ $rows }}"
        cols="{{ $cols }}"
        placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>