@props([
    'action',
    'method' => 'POST',
    'model' => null,
])

<form method ="{{ $method === 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" {{ $attributes->merge(['class' => 'space-y-6']) }}>
    @if ($method !== 'GET' && $method !== 'POST')
        @method($method)
    @endif

    @csrf

    {{ $slot }}
</form>