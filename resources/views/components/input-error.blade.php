@props(['error_key'])

@error($error_key)
    <p {!! $attributes->merge(['class' => 'input-error']) !!}>{{ $message }}</p>
@enderror
