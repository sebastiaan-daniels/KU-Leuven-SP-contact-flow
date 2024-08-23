@props(['disabled' => false])

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-2 border-black secondaryFocusBorder focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    {{ $slot }}

</select>
{{--border-gray-300 focus:border-indigo-500--}}
