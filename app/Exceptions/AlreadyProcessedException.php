<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AlreadyProcessedException extends Exception
{
    public function __construct(
        private readonly string $id,
        private readonly string $currentStatus
    ) { 
        parent::__construct(
            "{$id} already processed with {$currentStatus} status."
        );  
    }

    public function render(Request $request): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'data' => [
                'id' => $this->id,
                'current_status' => $this->currentStatus
            ]
        ], 409);
    }
}
