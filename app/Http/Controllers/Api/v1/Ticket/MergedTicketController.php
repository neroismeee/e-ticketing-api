<?php

namespace App\Http\Controllers\Api\v1\Ticket;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MergedTicketRequest;
use App\Http\Resources\Ticket\MergedTicketResource;
use App\Models\Ticket;
use App\Services\MergedTicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MergedTicketController extends Controller
{
    public function __construct(
        private readonly MergedTicketService $mergedService
    ) {}

    public function index(Ticket $ticket): JsonResponse
    {
        $mergedTickets = $this->mergedService->getMergedTickets($ticket);

        return ApiResponse::success(
            MergedTicketResource::collection($mergedTickets),
            'Merged tickets retrieved successfully.'
        );
    }

    public function mergeTicket(MergedTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $mergedTickets = $this->mergedService->merge(
            parentTicket: $ticket,
            mergedTicketIds: $request->validated('merged_ticket_ids')
        );

        return ApiResponse::success(
            MergedTicketResource::collection($mergedTickets),
            'Tickets merged successfully.'
        );
    }

    public function unmergeTicket(Ticket $ticket, string $mergedTicketId): JsonResponse 
    {
        $mergedTickets = $this->mergedService->unmerge($ticket, $mergedTicketId);
        
        return ApiResponse::success(
            MergedTicketResource::collection($mergedTickets),
            'Ticket unmerged successfully'
        );
    }
}
