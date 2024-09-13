@props(['disabled' => false, 'readOnly' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'x-input']) !!}>
