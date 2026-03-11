<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\TicketAlreadyConvertedException;
use App\Exceptions\TicketCannotBeConvertedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\ConvertToErrorReportRequest;
use App\Http\Requests\Ticket\ConvertToFeatureRequestRequest;
use App\Services\Ticket\TicketConversionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class TIcketConversionController extends Controller
{
    public function __construct(private TicketConversionService $service) {}

    public function toErrorReport(ConvertToErrorReportRequest $request, string $ticketId): JsonResponse
    {
        try {
            $errorReport = $this->service->convertToErrorReport($ticketId, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ticket successfully converted to Error Report',
                'data' => [
                    'source_ticket_id' => $ticketId,
                    'converted_to' => [
                        'type' => 'error_report',
                        'id' => $errorReport->id,
                        'redirect_url' => route('error-reports.show', $errorReport->id)
                    ],
                ],
            ], 201);
        } catch (TicketAlreadyConvertedException | TicketCannotBeConvertedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);

        } catch (\Exception $e) {
            Log::error('Conversion to Error Report failed', [
                'ticket_id' => $ticketId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'something went wrong.',
            ], 500);
        }
    }

    public function toFeatureRequest(ConvertToFeatureRequestRequest $request, string $ticketId): JsonResponse
    {
        try {
            $featureRequest = $this->service->convertToFeatureRequest($ticketId, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ticket successfully converted to Feature Request.',
                'data' => [
                    'source_ticket_id' => $ticketId,
                    'converted_to' => [
                        'type' => 'feature_request',
                        'id' => $featureRequest->id,
                        'redirect_url' => route('feature-requests.show', $featureRequest->id)
                    ]
                ]
            ], 201);

        } catch (TicketAlreadyConvertedException|TicketCannotBeConvertedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409);

        } catch (\Exception $e) {
            Log::error('Conversion to Feature Request failed.', [
                'ticket_id' => $ticketId,
                'user_id' => Auth::id(),
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        } 
    }
}
