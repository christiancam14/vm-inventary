<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryMovementService
{
    public function record(
        Product $product,
        InventoryMovementType $type,
        int $quantity,
        int $stockBefore,
        int $stockAfter,
        ?Model $reference = null,
        ?int $userId = null,
        ?string $notes = null,
    ): ?InventoryMovement {
        if ($quantity <= 0 || $stockBefore === $stockAfter) {
            return null;
        }

        return InventoryMovement::create([
            'product_id' => $product->id,
            'user_id' => $userId ?? Auth::id(),
            'type' => $type,
            'direction' => $type->direction(),
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference_id' => $reference?->getKey(),
            'reference_type' => $reference ? $reference::class : null,
            'notes' => $notes,
        ]);
    }
}
