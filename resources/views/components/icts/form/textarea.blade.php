@props(['disabled' => false])

<textarea
        {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-2 border-black secondaryFocusBorder rounded-md shadow-sm']) !!}
>{{ $slot }}</textarea>
