<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Carbon;

class TicketAlreadyConvertedException extends Exception
{
    public function __construct(
        private readonly string $ticketId,
        private readonly string $convertedToType,
        private readonly string $convertedToId,
        private readonly Carbon $convertedAt,
    ) {
        parent::__construct(
            "Ticket {$ticketId} already converted to " .
            strtoupper($convertedToType) . " ({$convertedToId}) " .
            "on {$convertedAt}."
             
        );
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse 
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'data' => [
                'ticket_id' => $this->ticketId,
                'converted_to_type' => $this->convertedToType,
                'converted_to_id' => $this->convertedToId,
                'converted_at' => $this->convertedAt ?? Carbon::now()
            ]
        ], 409);
    }

    // getter
    public function getTicketId(): string { return $this->ticketId; }
    public function getConvertedToType(): string { return $this->convertedToType; }
    public function getConvertedToId(): string { return $this->convertedToId; }
    public function getConvertedAt(): Carbon { return $this->convertedAt; }
}
