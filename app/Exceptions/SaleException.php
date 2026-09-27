<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SaleException extends Exception
{
    public static function creationFailed(string $message, array $context = []): self
    {
        Log::error("Sale creation failed: {$message}", $context);
        return new self(__('Failed to create sale: :message', ['message' => $message]));
    }

    public static function updateFailed(string $message, array $context = []): self
    {
        Log::error("Sale update failed: {$message}", $context);
        return new self(__('Failed to update sale: :message', ['message' => $message]));
    }

    public static function cancellationFailed(string $message, array $context = []): self
    {
        Log::error("Sale cancellation failed: {$message}", $context);
        return new self(__('Failed to cancel sale: :message', ['message' => $message]));
    }

    public static function invalidStatus(string $action, string $status, array $context = []): self
    {
        $message = __('This sale cannot change status while it is :status.', ['status' => $status]);
        Log::warning($message, $context);
        return new self($message);
    }

    public static function missingReference(string $reference, array $context = []): self
    {
        $message = __('Missing required reference: :reference.', ['reference' => __($reference)]);
        Log::warning($message, $context);
        return new self($message);
    }

    public static function insufficientStock(string $productName, int $requested, int $available): self
    {
        $message = __('Insufficient stock for product :product. Requested: :requested, Available: :available.', [
            'product' => $productName,
            'requested' => $requested,
            'available' => $available,
        ]);
        Log::warning($message);
        return new self($message);
    }

    public static function productNotFound(int $productId): self
    {
        $message = __('Product with ID :id not found during sale processing.', ['id' => $productId]);
        Log::error($message);
        return new self($message);
    }

    public static function invalidDiscount(string $reason): self
    {
        Log::warning("Invalid discount applied: {$reason}");
        return new self(__('Invalid discount: :reason', ['reason' => $reason]));
    }

    public static function insufficientPayment(float $total, float $received): self
    {
        $message = "Insufficient payment. Total: {$total}, Received: {$received}";
        Log::warning($message);
        return new self(__('Payment is insufficient. Please collect the full amount.'));
    }
}
