@props(['value'])

<small {{ $attributes->merge(['class' => 'block font-small text-sm text-gray-700 input-sublabel']) }}>
    {{ $value ?? $slot }}
</small>
