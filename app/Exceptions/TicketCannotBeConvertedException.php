<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketCannotBeConvertedException extends Exception
{

    public function __construct(
        private readonly string $ticketId,
        private readonly string $currentStatus,
        private readonly array $allowedStatuses = [
            'draft',
            'pending_approval',
            'assigned',
            'in_progress',
            'waiting_for_user'
        ],
    ) {
        $allowed = implode(',', $allowedStatuses);
        
        parent::__construct(
            "Ticket {$ticketId} with status {$currentStatus} can not be converted. " .
            "Allowed status: {$allowed}."
        );
    }
    /**
     * Report the exception.
     */
    public function render(): JsonResponse 
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'data' => [
                'ticket_id' => $this->ticketId,
                'status' => $this->currentStatus,
                'allowed_status' => $this->allowedStatuses
            ]
        ], 422);
    }

    // getter
    public function getTicketId():string { return $this->ticketId; }
    public function getCurrentStatus():string { return $this->currentStatus; }
    public function getAllowedStatuses():array { return $this->allowedStatuses; }
}
