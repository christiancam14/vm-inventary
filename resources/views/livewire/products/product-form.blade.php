<x-modal name="product-form-modal" :title="''" maxWidth="2xl">
    <div class="p-6">
        <!-- Custom Header -->
        <div class="mb-6 space-y-1.5 text-center sm:text-left border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-foreground">
                {{ $isEditing ? __('Edit Product') : __('Create Product') }}
            </h3>
            <p class="text-sm text-muted-foreground">
                {{ $isEditing ? __('Make changes to your product here. Click save when you\'re done.') : __('Add a new product to your inventory.') }}
            </p>
        </div>

        <form wire:submit="save" class="space-y-6">

            @unless($isEditing)
                <input type="hidden" wire:model="sku">
            @endunless

            <x-form-input
                name="name"
                :label="__('Product Name')"
                placeholder="e.g. Camiseta básica blanca - M"
                type="text"
                wire:model="name"
                required
            />

            @if($isEditing)
                <x-form-input
                    name="sku"
                    :label="__('SKU (Stock Keeping Unit)')"
                    type="text"
                    wire:model="sku"
                    readonly
                    placeholder="e.g. SKU-1234-ABCD"
                    class="bg-muted text-muted-foreground cursor-not-allowed"
                />
            @endif

            <div class="space-y-2">
                <x-form-input
                    name="barcode"
                    :label="__('Barcode (optional)')"
                    type="text"
                    wire:model="barcode"
                    :placeholder="__('Scan or type EAN/UPC — leave empty if unused')"
                />
                <p class="text-xs text-muted-foreground">{{ __('If set, you can scan this code in POS to add the product to the cart.') }}</p>
            </div>

            <!-- Row 2: Category & Unit -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Category -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="category_id" :value="__('Category')" required />
                    <div wire:ignore>
                        <x-tom-select
                            id="category_id"
                            name="category_id"
                            wire:model="category_id"
                            :url="route('ajax.categories.search')"
                            method="POST"
                            :placeholder="__('Select Category')"
                            data-initial-label="{{ $categoryName }}"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('category_id')" />
                </div>

                <!-- Unit -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="unit_id" :value="__('Unit')" required />
                    <div wire:ignore>
                        <x-tom-select
                            id="unit_id"
                            name="unit_id"
                            wire:model="unit_id"
                            :url="route('ajax.units.search')"
                            method="POST"
                            :placeholder="__('Select Unit')"
                            data-initial-label="{{ $unitName }}"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('unit_id')" />
                </div>
            </div>

            <!-- Prices (Forced Inline) -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Purchase Price -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="purchase_price" :value="__('Purchase Price') . ' (' . \App\Models\Setting::get('currency_symbol', 'Rp') . ')'" />
                    <x-currency-input
                        id="purchase_price"
                        wire:model.live.debounce.500ms="purchase_price"
                        placeholder="0"
                        required
                    />
                    <x-input-error :messages="$errors->get('purchase_price')" />
                </div>

                <!-- Selling Price -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="selling_price" :value="__('Selling Price') . ' (' . \App\Models\Setting::get('currency_symbol', 'Rp') . ')'" />
                    <x-currency-input
                        id="selling_price"
                        wire:model.live.debounce.500ms="selling_price"
                        placeholder="0"
                        required
                    />
                    <x-input-error :messages="$errors->get('selling_price')" />
                </div>
            </div>

            <div class="space-y-2 max-w-sm">
                <x-input-label for="max_discount" :value="__('Maximum discount') . ' (' . \App\Models\Setting::get('currency_symbol', '$') . ')'" />
                <x-currency-input
                    id="max_discount"
                    wire:model.live.debounce.500ms="max_discount"
                    placeholder="0"
                    required
                />
                <p class="text-xs text-muted-foreground">{{ __('The highest discount allowed per unit when this product is sold.') }}</p>
                <x-input-error :messages="$errors->get('max_discount')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
                <x-form-input
                    name="quantity"
                    :label="__('Quantity')"
                    type="number"
                    wire:model="quantity"
                    min="0"
                    placeholder="0"
                    required
                />

                <x-form-input
                    name="min_stock"
                    :label="__('Min Stock Alert')"
                    type="number"
                    wire:model="min_stock"
                    min="0"
                    placeholder="0"
                    required
                />

                <div class="space-y-2">
                    <x-input-label for="is_active" :value="__('Status')" />
                    <label for="is_active" class="flex h-10 items-center gap-3 cursor-pointer">
                        <input
                            id="is_active"
                            type="checkbox"
                            wire:model.live="is_active"
                            class="peer sr-only"
                        >
                        <span class="relative h-6 w-11 shrink-0 rounded-full bg-gray-200 transition-colors peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-checked:bg-primary after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-transform peer-checked:after:translate-x-5"></span>
                        <span class="text-sm font-medium text-foreground">
                            {{ $is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <x-input-label for="description" :value="__('Description')" />
                <textarea
                    id="description"
                    wire:model="description"
                    rows="3"
                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    placeholder="{{ __('Optional description...') }}"
                ></textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <x-input-label for="notes" :value="__('Internal Notes')" />
                <textarea
                    id="notes"
                    wire:model="notes"
                    rows="3"
                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    placeholder="{{ __('Internal pricing history & notes...') }}"
                ></textarea>
                <x-input-error :messages="$errors->get('notes')" />
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end gap-3 border-t pt-4 border-gray-200">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', { name: 'product-form-modal' })">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button type="submit" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <x-heroicon-o-check wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" />
                    {{ $isEditing ? __('Save Changes') : __('Create Product') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
