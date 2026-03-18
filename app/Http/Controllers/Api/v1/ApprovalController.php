<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\AlreadyProcessedException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest\FeatureApprovalRequest;
use App\Services\Ticket\FeatureApprovalService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\FeatureRequest\ApprovalResource;
use Illuminate\Http\JsonResponse;

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

            return ApiResponse::success(
                new ApprovalResource($featureRequest),
                $featureRequest->status === 'approved' ?
                'Feature Request successfully approved' :
                'Feature Request successfully rejected'
            ); 

        } catch (AlreadyProcessedException $e) {
            return ApiResponse::error(
                $e->getMessage(),
                409
            );

        } catch (\Exception $e) {
            Log::error('Approval Feature Request failed', [
                'feature_request_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return ApiResponse::error('Something went wrong.', 500);
        }
    }
}
