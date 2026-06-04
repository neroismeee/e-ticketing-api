<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversionHistory\ConversionHistoryResource;
use App\Http\Resources\ConversionHistory\ConversionHistoryResourceDetail;
use App\Models\ConversionHistory;
use App\Models\Ticket;
use App\Services\ConversionHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversionHistoryController extends Controller
{
    public function __construct(
        private readonly ConversionHistoryService $historyService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $histories = $this->historyService->getAll(
            filters: $request->only(['target_type', 'converted_by', 'from_date', 'to_date']),
            perPage: $request->integer('per_page', 15)
        );

        return ApiResponse::paginated(
            $histories,
            ConversionHistoryResource::collection($histories),
            'Conversion histories retrieved successfully.'
        );
    }

    public function show (ConversionHistory $history): JsonResponse
    {
        return ApiResponse::success(
            new ConversionHistoryResourceDetail($history->load(['sourceTicket', 'converter'])),
            'Conversion histories retrieved successfully.'
        );
    }

    public function byTicket (Ticket $ticket): JsonResponse
    {
        $history = $this->historyService->getByTicket($ticket);

        return ApiResponse::success(
            $history ? new ConversionHistoryResourceDetail($history) : null,
            $history ? 'Conversion history retrieved successfully.'
            : 'This ticket has not been converted.'
        );
    }
}
