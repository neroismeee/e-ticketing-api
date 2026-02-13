<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest\StoreFeatureRequest;
use App\Http\Requests\FeatureRequest\UpdateFeatureRequest;
use App\Http\Resources\FeatureDetailResource;
use App\Http\Resources\FeatureResource;
use App\Models\FeatureRequest;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feature = FeatureRequest::with(['assignee', 'reporter', 'approver'])
            ->latest()
            ->paginate(10);

        return ApiResponse::paginated(
            $feature,
            FeatureResource::collection($feature),
            'Feature Request retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeatureRequest $request)
    {
        $feature = FeatureRequest::create($request->validated());

        return ApiResponse::success(
            new FeatureDetailResource($feature),
            'Feature Request created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FeatureRequest $feature)
    {
        $feature->load(['assignee', 'reporter', 'approver']);

        return ApiResponse::success(
            new FeatureDetailResource($feature),
            'Feature Request retrieved successfully',
        );
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeatureRequest $request, FeatureRequest $feature)
    {
        $feature->update($request->validated());

        return ApiResponse::success(
            new FeatureDetailResource($feature),
            'Feature Request updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureRequest $feature)
    {
        $feature->delete();

        return ApiResponse::success(
            null,
            'Feature Request deleted successfully'
        );
    }
}
