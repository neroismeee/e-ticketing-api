<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Milestone\StoreMilestoneRequest;
use App\Http\Requests\Milestone\UpdateMilestoneProgressRequest;
use App\Http\Requests\Milestone\UpdateMilestoneRequest;
use App\Http\Resources\Milestone\MilestoneResource;
use App\Http\Resources\Milestone\MilestoneDetailResource;
use App\Models\FeatureRequest;
use App\Models\Milestone;
use App\Services\MilestoneService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function __construct(
        private readonly MilestoneService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FeatureRequest $feature): JsonResponse
    {
        $milestones = $this->service->getByFeatureRequest(
            feature: $feature,
            filters: $request->only(['is_completed', 'overdue']),
            perPage: $request->integer('per_page', 15)
        );

        return ApiResponse::paginated(
            $milestones,
            MilestoneResource::collection($milestones),
            'Milestones retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMilestoneRequest $request, FeatureRequest $feature): JsonResponse
    {
        $milestone = $this->service->store($feature, $request->validated());

        return ApiResponse::success(
            new MilestoneResource($milestone),
            'Milestone created successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FeatureRequest $feature, Milestone $milestone): JsonResponse
    {
        if ((string) $milestone->feature_request_id !== (string) $feature->id) {
            abort(403, 'This milestone does not belong to that feature request');
        }

        return ApiResponse::success(
            new MilestoneDetailResource($milestone->load('creator')),
            'Milestone retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMilestoneRequest $request, FeatureRequest $feature, Milestone $milestone): JsonResponse
    {
        if ((string) $milestone->feature_request_id !== (string) $feature->id) {
            abort(403, 'This milestone does not belong to that feature request');
        }

        $updated = $this->service->update($milestone, $request->validated());

        return ApiResponse::success(
            new MilestoneResource($updated),
            'Milestone updated successfully.'
        );
    }

    public function updateProgress(UpdateMilestoneProgressRequest $request, FeatureRequest $feature, Milestone $milestone): JsonResponse
    {
        if ((string) $milestone->feature_request_id !== (string) $feature->id) {
            abort(403, 'This milestone does not belong to that feature request');
        }

        $updated = $this->service->updateProgress($milestone, $request->validated('progress'));

        return ApiResponse::success(
            new MilestoneResource($updated),
            'Milestone progress updated successfully.'
        );
    }

    public function complete(FeatureRequest $feature, Milestone $milestone): JsonResponse
    {
        if ((string) $milestone->feature_request_id !== (string) $feature->id) {
            abort(403, 'This milestone does not belong to that feature request');
        }

        $updated = $this->service->complete($milestone);

        return ApiResponse::success(
            new MilestoneResource($updated),
            'Milestone marked as completed.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureRequest $feature, Milestone $milestone): JsonResponse
    {
        if ((string) $milestone->feature_request_id !== (string) $feature->id) {
            abort(403, 'This milestone does not belong to that feature request');
        }

        $this->service->delete($milestone);

        return ApiResponse::success(
            null,
            'Milestone deleted successfully'
        );
    }
}
