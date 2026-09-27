<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryMovement;
use App\Enums\InventoryMovementType;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class InventoryMovementTable extends PowerGridComponent
{
    public string $tableName = 'inventory-movement-table';
    public string $sortField = 'inventory_movements.created_at';
    public string $sortDirection = 'desc';

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(perPage: 10, perPageValues: [10, 25, 50, 100])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return InventoryMovement::query()
            ->select('inventory_movements.*')
            ->leftJoin('products', 'products.id', '=', 'inventory_movements.product_id')
            ->leftJoin('users', 'users.id', '=', 'inventory_movements.user_id')
            ->with(['product', 'user', 'reference']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at')
            ->add('created_at_formatted', fn (InventoryMovement $model) => $model->created_at?->format('d/m/Y H:i'))
            ->add('product_name', fn (InventoryMovement $model) => $model->product?->name ?? '—')
            ->add('type')
            ->add('type_label', fn (InventoryMovement $model) => $model->type->label())
            ->add('direction_label', function (InventoryMovement $model) {
                $label = $model->direction === 'in' ? __('Stock in') : __('Stock out');
                $class = $model->direction === 'in'
                    ? 'text-emerald-700 bg-emerald-50'
                    : 'text-red-700 bg-red-50';

                return '<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium '.$class.'">'.$label.'</span>';
            })
            ->add('quantity')
            ->add('quantity_formatted', function (InventoryMovement $model) {
                $sign = $model->direction === 'in' ? '+' : '−';

                return $sign.$model->quantity;
            })
            ->add('stock_before')
            ->add('stock_after')
            ->add('user_name', fn (InventoryMovement $model) => $model->user?->name ?? __('Unknown user'))
            ->add('reference_label', fn (InventoryMovement $model) => $model->referenceLabel());
    }

    public function columns(): array
    {
        return [
            Column::make(__('Date'), 'created_at_formatted', 'inventory_movements.created_at')
                ->sortable(),

            Column::make(__('Product'), 'product_name', 'products.name')
                ->searchable()
                ->sortable(),

            Column::make(__('Type'), 'type_label', 'inventory_movements.type')
                ->sortable(),

            Column::make(__('Direction'), 'direction_label', 'inventory_movements.direction')
                ->sortable(),

            Column::make(__('Qty'), 'quantity_formatted', 'inventory_movements.quantity')
                ->sortable()
                ->bodyAttribute('text-right font-medium'),

            Column::make(__('Stock before'), 'stock_before', 'inventory_movements.stock_before')
                ->sortable()
                ->bodyAttribute('text-right'),

            Column::make(__('Stock after'), 'stock_after', 'inventory_movements.stock_after')
                ->sortable()
                ->bodyAttribute('text-right'),

            Column::make(__('User'), 'user_name', 'users.name')
                ->searchable()
                ->sortable(),

            Column::make(__('Reference'), 'reference_label'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('type_label', 'inventory_movements.type')
                ->dataSource(collect(InventoryMovementType::cases())->map(fn (InventoryMovementType $type) => [
                    'value' => $type->value,
                    'label' => $type->label(),
                ]))
                ->optionValue('value')
                ->optionLabel('label'),
        ];
    }
}
