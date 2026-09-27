<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CustomerException extends Exception
{
    public static function creationFailed(string $message, array $context = []): self
    {
        Log::error("Failed to create customer: {$message}", $context);
        return new self(__('Failed to create customer: :message', ['message' => $message]));
    }

    public static function updateFailed(string $message, array $context = []): self
    {
        Log::error("Failed to update customer: {$message}", $context);
        return new self(__('Failed to update customer: :message', ['message' => $message]));
    }

    public static function deletionFailed(string $message, array $context = []): self
    {
        Log::error("Failed to delete customer: {$message}", $context);
        return new self(__('Failed to delete customer: :message', ['message' => $message]));
    }
}
