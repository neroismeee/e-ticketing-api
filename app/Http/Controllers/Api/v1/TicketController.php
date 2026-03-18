<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Models\Ticket;
use App\Http\Resources\TicketDetailResource;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): JsonResponse
    {
        $tickets = Ticket::with(['reportedTickets', 'assignedTickets'])
            ->latest()
            ->paginate(10);
        return ApiResponse::paginated(
            $tickets,
            TicketResource::collection($tickets),
            'Tickets retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function __construct(private TicketService $service) {}

    public function store(StoreTicketRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $this->service->generateTicketId(); 
        
        $ticket = Ticket::create($data);

        return ApiResponse::success(
            new TicketDetailResource($ticket),
            'Ticket Created Successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load(['reportedTickets', 'assignedTickets']);

        return ApiResponse::success(
            new TicketDetailResource($ticket),
            'Ticket retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $ticket->update($request->validated());

        return ApiResponse::success(
            new TicketDetailResource($ticket),
            'Ticket updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return ApiResponse::success(
            null,
            'Ticket deleted successfully'
        );
    }
}
