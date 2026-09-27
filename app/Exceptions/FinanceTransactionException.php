<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class FinanceTransactionException extends Exception
{
    public static function creationFailed(string $message, array $context = []): self
    {
        Log::error("Finance Transaction creation failed: {$message}", $context);
        return new self(__('Failed to create transaction. :message', ['message' => $message]));
    }

    public static function updateFailed(string $message, array $context = []): self
    {
        Log::error("Finance Transaction update failed: {$message}", $context);
        return new self(__('Failed to update transaction. :message', ['message' => $message]));
    }

    public static function deletionFailed(string $message, array $context = []): self
    {
        Log::error("Finance Transaction deletion failed: {$message}", $context);
        return new self(__('Failed to delete transaction. :message', ['message' => $message]));
    }
}
