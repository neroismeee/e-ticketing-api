<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class MentionLimitExceededException extends Exception
{
    public function __construct(
        public readonly int $limit,
        public readonly int $given,
    ) {
        parent::__construct(
            "Mention limit exceeded. Maximum {$limit}, given {$given}"
        );
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => 'mention_limit_exceeded',
            'message' => "Max {$this->limit} mentions per comment",
            'meta' => [
                'limit' => $this->limit,
                'given' => $this->given
            ]
        ], 422);
    }
}
