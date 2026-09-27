@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-sm px-3 py-2 text-start text-sm leading-5 font-medium text-stone-900 bg-[#f3eadc] focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full rounded-sm px-3 py-2 text-start text-sm leading-5 text-stone-600 hover:bg-stone-100 hover:text-stone-900 focus:outline-none focus:bg-stone-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
