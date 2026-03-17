<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\AlreadyProcessedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest\FeatureApprovalRequest;
use App\Services\Ticket\FeatureApprovalService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApprovalController extends Controller
{
    public function __construct(private FeatureApprovalService $service) {}

    public function approveFeatureRequest(
        FeatureApprovalRequest $request,
        string $id
    ): JsonResponse
    {
        try {
            $featureRequest = $this->service->processFeatureRequest($id, $request->validated());

            return response()->json([
                'success' =>  true,
                'message' => $featureRequest->status === 'approved' ? 
                    'Feature Request successfully approved' : 
                    'Feature Request successfully rejected',
                'data' => [
                    'id' => $featureRequest->id,
                    'status' => $featureRequest->status,
                    'approved_by' => $featureRequest->approved_by,
                    'approved_date' => Carbon::now()->toDateString(),
                    'rejection_reason' => $featureRequest->rejection_reason
                ],
            ]); 

        } catch (AlreadyProcessedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);

        } catch (\Exception $e) {
            Log::error('Approval Feature Request failed', [
                'feature_request_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }

        
    }
}
