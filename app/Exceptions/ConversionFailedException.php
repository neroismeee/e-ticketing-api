<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConversionFailedException extends Exception
{
    public function __construct(
        private readonly string $ticketId,
        private readonly array $context = [],
        string $message = '',

    ) {
        $resolvedMessage = $message ?: $context['message'] ?? 'Conversion failed.';
        parent::__construct($resolvedMessage);
    }
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Conversion failed', [
            'ticket_id' => $this->ticketId,
            'context' => $this->context,
            'message' => $this->getMessage(),
            'trace' => $this->getTraceAsString()
        ]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage()
        ], 500);
    }

    // getter
    public function getTicketId(): string { return $this->ticketId; }
    public function getContext(): array { return $this->context; }
}
