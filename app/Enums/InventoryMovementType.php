<?php

namespace App\Enums;

enum InventoryMovementType: string
{
    case InitialStock = 'initial_stock';
    case AdjustmentIn = 'adjustment_in';
    case AdjustmentOut = 'adjustment_out';
    case Sale = 'sale';
    case SaleReturn = 'sale_return';
    case SaleRestore = 'sale_restore';
    case PurchaseReceipt = 'purchase_receipt';

    public function label(): string
    {
        return match ($this) {
            self::InitialStock => __('Initial stock'),
            self::AdjustmentIn => __('Manual stock in'),
            self::AdjustmentOut => __('Manual stock out'),
            self::Sale => __('Sale'),
            self::SaleReturn => __('Sale return'),
            self::SaleRestore => __('Sale restored'),
            self::PurchaseReceipt => __('Purchase receipt'),
        };
    }

    public function direction(): string
    {
        return match ($this) {
            self::AdjustmentOut, self::Sale, self::SaleRestore => 'out',
            default => 'in',
        };
    }
}
