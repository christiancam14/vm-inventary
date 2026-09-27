<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class PurchaseException extends Exception
{
    public static function creationFailed(string $message, array $context = []): self
    {
        Log::error("Purchase creation failed: {$message}", $context);
        return new self(__('Failed to create purchase: :message', ['message' => $message]));
    }

    public static function updateFailed(string $message, array $context = []): self
    {
        Log::error("Purchase update failed: {$message}", $context);
        return new self(__('Failed to update purchase: :message', ['message' => $message]));
    }

    public static function deletionFailed(string $message, array $context = []): self
    {
        Log::error("Purchase deletion failed: {$message}", $context);
        return new self(__('Failed to delete purchase. :message', ['message' => $message]));
    }

    public static function invalidStatus(string $action, string $status, array $context = []): self
    {
        $message = __('This purchase cannot change status while it is :status.', ['status' => $status]);
        Log::warning($message, $context);
        return new self($message);
    }

    public static function missingReference(string $reference, array $context = []): self
    {
        $message = __('Missing required reference: :reference.', ['reference' => __($reference)]);
        Log::warning($message, $context);
        return new self($message);
    }
}
