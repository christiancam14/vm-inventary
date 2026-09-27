@php
    $navLink = 'relative inline-flex h-16 items-center gap-2 px-3 text-[13px] font-medium tracking-wide text-stone-400 transition-colors hover:text-[#f7f3ec]';
    $navLinkActive = 'relative inline-flex h-16 items-center gap-2 px-3 text-[13px] font-medium tracking-wide text-[#f7f3ec] after:absolute after:inset-x-3 after:bottom-0 after:h-px after:bg-[#c4a574]';
    $navIcon = 'h-4 w-4 shrink-0 text-[#c4a574]';
    $accountInitials = collect(explode(' ', Auth::user()->name))
        ->filter()
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->take(2)
        ->join('');
@endphp

<header class="sticky top-0 z-40 border-b border-[#c4a574]/35 bg-[#161513] text-[#f7f3ec] shadow-[0_10px_30px_-18px_rgba(0,0,0,0.7)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
        <nav class="hidden items-center justify-between lg:flex">
            <div class="flex min-w-0 items-center gap-6">
                <x-brand-mark />

                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $navLinkActive : $navLink }}">
                        <x-heroicon-o-squares-2x2 class="{{ $navIcon }}" />
                        {{ __('Dashboard') }}
                    </a>

                    <x-nav-dropdown active="{{ request()->routeIs(['sales.*', 'customers.*']) }}">
                        <x-slot name="icon">
                            <x-heroicon-o-banknotes class="{{ $navIcon }}" />
                        </x-slot>
                        <x-slot name="trigger">
                            {{ __('Sales') }}
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                                {{ __('POS') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('sales.index')" :active="request()->routeIs(['sales.index', 'sales.show'])">
                                {{ __('Sales') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                                {{ __('Customers') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-nav-dropdown>

                    <x-nav-dropdown active="{{ request()->routeIs(['purchases.*', 'suppliers.*']) }}">
                        <x-slot name="icon">
                            <x-heroicon-o-shopping-cart class="{{ $navIcon }}" />
                        </x-slot>
                        <x-slot name="trigger">
                            {{ __('Purchases') }}
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                                {{ __('Purchases') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                                {{ __('Suppliers') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-nav-dropdown>

                    <x-nav-dropdown active="{{ request()->routeIs(['finance.*']) }}">
                        <x-slot name="icon">
                            <x-heroicon-o-currency-dollar class="{{ $navIcon }}" />
                        </x-slot>
                        <x-slot name="trigger">
                            {{ __('Finance') }}
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('finance.transactions.index')" :active="request()->routeIs('finance.transactions.index')">
                                {{ __('Transactions') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('finance.categories.index')" :active="request()->routeIs('finance.categories.index')">
                                {{ __('Categories') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-nav-dropdown>

                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? $navLinkActive : $navLink }}">
                        <x-heroicon-o-users class="{{ $navIcon }}" />
                        {{ __('Users') }}
                    </a>

                    <x-nav-dropdown active="{{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'low-stock.*', 'inventory-movements.*']) }}">
                        <x-slot name="icon">
                            <x-heroicon-o-cube class="{{ $navIcon }}" />
                        </x-slot>
                        <x-slot name="trigger">
                            {{ __('Products') }}
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                                {{ __('Products') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('low-stock.index')" :active="request()->routeIs('low-stock.*')">
                                {{ __('Low Stock') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('inventory-movements.index')" :active="request()->routeIs('inventory-movements.*')">
                                {{ __('Inventory movements') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Categories') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('units.index')" :active="request()->routeIs('units.*')">
                                {{ __('Units') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-nav-dropdown>
                </div>
            </div>

            <div class="flex shrink-0 items-center">
                <x-dropdown align="right" width="48" contentClasses="bg-[#fbfaf7] py-1.5">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 py-1 pl-1 pr-3 text-left transition-colors hover:border-[#c4a574]/60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#c4a574]/70">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#c4a574]/15 text-[11px] font-semibold tracking-wide text-[#e8d7b8]">
                                {{ $accountInitials }}
                            </span>
                            <span class="hidden xl:block leading-none">
                                <span class="block max-w-[9rem] truncate text-xs font-medium text-[#f7f3ec]">{{ Auth::user()->name }}</span>
                                <span class="mt-1 block text-[10px] uppercase tracking-[0.16em] text-stone-400">{{ __('Account') }}</span>
                            </span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>

        <div class="flex h-16 items-center justify-between lg:hidden">
            <x-brand-mark compact />

            <button @click="mobileMenuOpen = true" type="button" class="inline-flex h-10 w-10 items-center justify-center border border-white/10 text-[#f7f3ec] transition-colors hover:border-[#c4a574]/60" aria-label="{{ __('Open menu') }}">
                <x-heroicon-o-bars-3 class="h-5 w-5" />
            </button>
        </div>

        <div x-show="mobileMenuOpen"
            x-transition:enter="duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50"
            style="display: none;"
            @click="mobileMenuOpen = false">
        </div>

        <div x-show="mobileMenuOpen"
            x-transition:enter="duration-300 ease-out"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="duration-200 ease-in"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 z-50 flex h-full w-[min(100%,22rem)] flex-col border-l border-[#c4a574]/30 bg-[#161513] p-6 text-[#f7f3ec] shadow-2xl"
            style="display: none;"
            @click.stop>

            <div class="flex items-center justify-between">
                <x-brand-mark />
                <button @click="mobileMenuOpen = false" type="button" class="inline-flex h-9 w-9 items-center justify-center text-stone-300 hover:text-[#f7f3ec]">
                    <span class="sr-only">{{ __('Close') }}</span>
                    <x-heroicon-o-x-mark class="h-5 w-5" />
                </button>
            </div>

            <div class="mt-8 flex flex-1 flex-col gap-5 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium tracking-wide {{ request()->routeIs('dashboard') ? 'text-[#e8d7b8]' : 'text-stone-300' }}">{{ __('Dashboard') }}</a>

                <div x-data="{ expanded: {{ request()->routeIs(['sales.*', 'customers.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" type="button" class="flex w-full items-center justify-between text-sm font-medium tracking-wide {{ request()->routeIs(['sales.*', 'customers.*']) ? 'text-[#e8d7b8]' : 'text-stone-300' }}">
                        {{ __('Sales') }}
                        <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="mt-3 flex flex-col gap-2 border-l border-[#c4a574]/30 pl-4">
                            <a class="py-1 text-sm {{ request()->routeIs('sales.create') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('sales.create') }}">{{ __('POS') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs(['sales.index', 'sales.show']) ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('sales.index') }}">{{ __('Sales') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('customers.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('customers.index') }}">{{ __('Customers') }}</a>
                        </div>
                    </div>
                </div>

                <div x-data="{ expanded: {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" type="button" class="flex w-full items-center justify-between text-sm font-medium tracking-wide {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'text-[#e8d7b8]' : 'text-stone-300' }}">
                        {{ __('Purchases') }}
                        <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="mt-3 flex flex-col gap-2 border-l border-[#c4a574]/30 pl-4">
                            <a class="py-1 text-sm {{ request()->routeIs('purchases.*') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('purchases.index') }}">{{ __('Purchases') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('suppliers.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('suppliers.index') }}">{{ __('Suppliers') }}</a>
                        </div>
                    </div>
                </div>

                <div x-data="{ expanded: {{ request()->routeIs(['finance.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" type="button" class="flex w-full items-center justify-between text-sm font-medium tracking-wide {{ request()->routeIs(['finance.*']) ? 'text-[#e8d7b8]' : 'text-stone-300' }}">
                        {{ __('Finance') }}
                        <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="mt-3 flex flex-col gap-2 border-l border-[#c4a574]/30 pl-4">
                            <a class="py-1 text-sm {{ request()->routeIs('finance.transactions.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('finance.transactions.index') }}">{{ __('Transactions') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('finance.categories.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('finance.categories.index') }}">{{ __('Categories') }}</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('users.index') }}" class="text-sm font-medium tracking-wide {{ request()->routeIs('users.*') ? 'text-[#e8d7b8]' : 'text-stone-300' }}">{{ __('Users') }}</a>

                <div x-data="{ expanded: {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'low-stock.*', 'inventory-movements.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" type="button" class="flex w-full items-center justify-between text-sm font-medium tracking-wide {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'low-stock.*', 'inventory-movements.*']) ? 'text-[#e8d7b8]' : 'text-stone-300' }}">
                        {{ __('Products') }}
                        <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="mt-3 flex flex-col gap-2 border-l border-[#c4a574]/30 pl-4">
                            <a class="py-1 text-sm {{ request()->routeIs('products.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('products.index') }}">{{ __('Products') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('low-stock.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('low-stock.index') }}">{{ __('Low Stock') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('inventory-movements.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('inventory-movements.index') }}">{{ __('Inventory movements') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('categories.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('categories.index') }}">{{ __('Categories') }}</a>
                            <a class="py-1 text-sm {{ request()->routeIs('units.index') ? 'text-[#e8d7b8]' : 'text-stone-400' }}" href="{{ route('units.index') }}">{{ __('Units') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-white/10 pt-5">
                <p class="text-sm font-medium text-[#f7f3ec]">{{ Auth::user()->name }}</p>
                <p class="mt-1 text-[10px] uppercase tracking-[0.16em] text-stone-400">{{ __('Account') }}</p>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('profile.index') }}" class="border border-white/10 px-3 py-2 text-center text-sm text-stone-200 hover:border-[#c4a574]/60">{{ __('Profile') }}</a>
                    <a href="{{ route('settings.index') }}" class="border border-white/10 px-3 py-2 text-center text-sm text-stone-200 hover:border-[#c4a574]/60">{{ __('Settings') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full border border-[#c4a574]/50 px-3 py-2 text-sm text-[#e8d7b8] hover:bg-[#c4a574]/10">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
