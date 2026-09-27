<?php

namespace App\Models;

use App\Enums\InventoryMovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'direction',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_id',
        'reference_type',
        'notes',
    ];

    protected $casts = [
        'type' => InventoryMovementType::class,
        'quantity' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function referenceLabel(): string
    {
        $reference = $this->reference;

        if ($reference instanceof Sale) {
            return __('Sale') . ' ' . ($reference->invoice_number ?: '#' . $reference->id);
        }

        if ($reference instanceof Purchase) {
            return __('Purchase') . ' ' . ($reference->invoice_number ?: '#' . $reference->id);
        }

        return $this->notes ?: '—';
    }
}
