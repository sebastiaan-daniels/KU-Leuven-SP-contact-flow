@props(['disabled' => false])

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'mt-1 border-2 border-gray-200 secondaryFocusBorder focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    {{ $slot }}

</select>
{{--border-gray-300 focus:border-indigo-500--}}
