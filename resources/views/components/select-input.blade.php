@props(['disabled' => false, 'readOnly' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'x-select']) !!}>
    {{$slot}}
</select>
