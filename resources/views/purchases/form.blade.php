<div class="space-y-6">
    <!-- Header Input Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
        <!-- Supplier -->
        <div class="space-y-2">
            <x-input-label for="supplier_id" :value="__('Supplier')" required />
            <div class="w-full">
                <select id="supplier_id" name="supplier_id"
                        x-init="initSupplierSelect($el)"
                        x-model="supplier_id"
                        autocomplete="off">
                    <option value=""></option>
                    @if(old('supplier_id'))
                        @php
                            $oldSupplier = \App\Models\Supplier::find(old('supplier_id'));
                        @endphp
                        @if($oldSupplier)
                            <option value="{{ $oldSupplier->id }}" selected>{{ $oldSupplier->name . ($oldSupplier->phone ? ' | ' . $oldSupplier->phone : '') }}</option>
                        @endif
                    @elseif(isset($purchase) && $purchase->supplier)
                        <option value="{{ $purchase->supplier_id }}" selected>{{ $purchase->supplier->name . ($purchase->supplier->phone ? ' | ' . $purchase->supplier->phone : '') }}</option>
                    @endif
                </select>
            </div>
            <x-input-error :messages="$errors->get('supplier_id')" />
        </div>

        <!-- Invoice (Optional) -->
        <div class="space-y-2">
            <x-input-label for="invoice_number" :value="__('Invoice Number (Optional)')" />
            <x-text-input
                id="invoice_number"
                type="text"
                name="invoice_number"
                :value="old('invoice_number', $purchase->invoice_number ?? '')"
                :placeholder="__('Leave empty for drafts')"
                class="block w-full"
            />
            <x-input-error :messages="$errors->get('invoice_number')" />
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-input-label for="purchase_date" :value="__('Purchase Date')" required />
                <x-text-input
                    id="purchase_date"
                    type="date"
                    name="purchase_date"
                    :value="old('purchase_date', $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') : date('Y-m-d'))"
                    class="block w-full"
                />
                <x-input-error :messages="$errors->get('purchase_date')" />
            </div>
            <div class="space-y-2">
                <x-input-label for="due_date" :value="__('Due Date')" />
                <x-text-input
                    id="due_date"
                    type="date"
                    name="due_date"
                    :value="old('due_date', $purchase->due_date ? \Carbon\Carbon::parse($purchase->due_date)->format('Y-m-d') : '')"
                    class="block w-full"
                />
                <x-input-error :messages="$errors->get('due_date')" />
            </div>
        </div>

         <!-- Status (Read Only) -->
         <div class="space-y-2">
            <x-input-label :value="__('Status')" />
            <div class="flex h-10 w-full items-center rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-500">
                {{ isset($purchase) && $purchase->status ? $purchase->status->label() : __('Draft (Default)') }}
            </div>
        </div>

        <!-- Amount -->
        <div class="space-y-2">
            <x-input-label for="purchase_amount" :value="__('Purchase amount')" required />
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500" x-text="window.currencySymbol"></span>
                <input
                    id="purchase_amount"
                    type="text"
                    inputmode="numeric"
                    autocomplete="off"
                    x-model="amountDisplay"
                    @input="onAmountInput($event)"
                    class="flex h-10 w-full rounded-md border border-input bg-background pl-8 pr-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    placeholder="0"
                    required
                >
            </div>
            <input type="hidden" name="total" :value="total">
            <p class="text-sm text-muted-foreground">{{ __('Record only the total value of this purchase.') }}</p>
            <x-input-error :messages="$errors->get('total')" />
        </div>

        <!-- Notes -->
        <div class="md:col-span-2 space-y-2">
            <x-input-label for="notes" :value="__('Notes')" />
            <textarea
                id="notes"
                name="notes"
                rows="2"
                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                placeholder="{{ __('Additional notes...') }}"
            >{{ old('notes', $purchase->notes ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('notes')" />
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-x-4 pt-6 border-t border-gray-200">
        <a href="{{ route('purchases.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            {{ __('Cancel') }}
        </a>

        <x-primary-button class="flex items-center gap-2" ::disabled="loading">
            <svg x-show="loading" class="animate-spin -ml-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span x-text="loading ? {{ Js::from(__('Processing...')) }} : {{ Js::from(isset($purchase->id) ? __('Update Purchase') : __('Create Purchase')) }}"></span>
        </x-primary-button>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('purchaseForm', (initialData) => ({
            supplier_id: initialData.supplier_id || '',
            total: initialData.total === null || initialData.total === undefined || initialData.total === '' ? '' : String(initialData.total),
            amountDisplay: '',
            loading: false,
            errors: initialData.errors || {},

            init() {
                if (this.total !== '') {
                    const numeric = parseFloat(this.total);
                    this.total = Number.isNaN(numeric) ? '' : String(numeric);
                    this.amountDisplay = this.formatAmount(this.total);
                }
            },

            formatAmount(value) {
                if (value === '' || value === null || value === undefined) {
                    return '';
                }

                const fraction = window.currencyFraction || 0;
                const thousand = window.thousandSeparator || '.';
                const decimal = window.decimalSeparator || ',';
                const parts = String(value).split('.');
                let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousand);

                if (fraction > 0 && parts.length > 1) {
                    return integerPart + decimal + parts[1];
                }

                return integerPart;
            },

            onAmountInput(event) {
                const fraction = window.currencyFraction || 0;
                const thousand = window.thousandSeparator || '.';
                const decimal = window.decimalSeparator || ',';
                let cleaned = String(event.target.value).split(thousand).join('');

                if (fraction > 0) {
                    cleaned = cleaned.replace(decimal, '.');
                    cleaned = cleaned.replace(/[^\d.]/g, '');
                    const parts = cleaned.split('.');
                    const decimals = parts.length > 1 ? parts.slice(1).join('').slice(0, fraction) : '';
                    cleaned = parts[0] + (decimals !== '' ? '.' + decimals : '');
                } else {
                    cleaned = cleaned.replace(/\D/g, '');
                }

                this.total = cleaned;
                this.amountDisplay = this.formatAmount(cleaned);
            },

            submitForm(e) {
                if (this.loading) return;
                this.loading = true;
                e.target.submit();
            },

            waitForTomSelect(callback) {
                if (window.TomSelect) {
                    callback();
                } else {
                    setTimeout(() => this.waitForTomSelect(callback), 50);
                }
            },

            initSupplierSelect(el) {
                let self = this;
                this.waitForTomSelect(() => {
                    new TomSelect(el, {
                        placeholder: @json(__('Select Supplier...')),
                        preload: 'focus',
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        onChange: function(value) {
                            self.supplier_id = value;
                        },
                        load: function(query, callback) {
                            var url = '{{ route("ajax.suppliers.search") }}';

                            fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ q: query })
                            })
                                .then(response => response.json())
                                .then(json => {
                                    callback(json);
                                }).catch(() => {
                                    callback();
                                });
                        }
                    });
                });
            }
        }));
    });
</script>
@endpush
