@props(['compact' => false])

<a href="{{ route('dashboard') }}" {{ $attributes->merge(['class' => 'group flex items-center gap-3']) }}>
    <span class="flex h-9 w-9 shrink-0 items-center justify-center border border-[#c4a574]/80 text-[11px] font-semibold tracking-[0.16em] text-[#e8d7b8] transition-colors group-hover:border-[#f3e6cf] group-hover:text-[#f7f3ec]">
        VM
    </span>
    <span class="flex flex-col leading-none">
        <span class="text-[13px] font-semibold tracking-[0.22em] text-[#f7f3ec]">VM POS</span>
        @unless($compact)
            <span class="mt-1 text-[10px] uppercase tracking-[0.18em] text-stone-400">{{ __('Point of sale') }}</span>
        @endunless
    </span>
</a>
