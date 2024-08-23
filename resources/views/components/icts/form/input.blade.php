@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-2 border-black secondaryFocusBorder rounded-md shadow-sm']) !!}>
