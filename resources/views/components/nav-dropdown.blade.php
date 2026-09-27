@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'group relative inline-flex h-16 items-center gap-2 px-3 text-[13px] font-medium tracking-wide text-[#f7f3ec] after:absolute after:inset-x-3 after:bottom-0 after:h-px after:bg-[#c4a574]'
            : 'group relative inline-flex h-16 items-center gap-2 px-3 text-[13px] font-medium tracking-wide text-stone-400 transition-colors hover:text-[#f7f3ec]';
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @mouseleave="open = false">
    <button @click="open = !open" @mouseover="open = true" :class="open ? 'text-[#f7f3ec]' : ''" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $icon }}
        {{ $trigger }}
        <x-heroicon-o-chevron-down class="h-3 w-3 opacity-70 transition duration-200" x-bind:class="open ? 'rotate-180' : ''" />
    </button>
    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute left-0 top-full z-50 min-w-[15rem] pt-2 outline-none"
            style="display: none;">
        <div class="relative rounded-md border border-stone-200/80 bg-[#fbfaf7] p-1.5 text-stone-800 shadow-[0_18px_40px_-16px_rgba(20,19,17,0.45)]">
            <div class="flex flex-col">
                {{ $content }}
            </div>
        </div>
    </div>
</div>
