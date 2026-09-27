<x-app-layout title="Edit Purchase">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Edit Purchase') }} #{{ $purchase->id }}
            </h2>
            <x-secondary-button href="{{ route('purchases.index') }}">
                &larr; {{ __('Back to List') }}
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('purchases.update', $purchase) }}" method="POST"
                    x-data="purchaseForm({
                        supplier_id: {{ Js::from(old('supplier_id', $purchase->supplier_id)) }},
                        total: {{ Js::from(old('total', $purchase->total)) }},
                        errors: {{ Js::from($errors->any() ? $errors->toArray() : []) }}
                    })"
                    @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                @include('purchases.form')

            </form>
        </div>
    </div>
</x-app-layout>
