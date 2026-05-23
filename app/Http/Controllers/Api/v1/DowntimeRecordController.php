<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DowntimeRecord\ResolveDowntimeRecordRequest;
use App\Http\Requests\DowntimeRecord\StoreDowntimeRecordRequest;
use App\Http\Requests\DowntimeRecord\UpdateDowntimeRecordRequest;
use App\Http\Resources\DowntimeRecordResource;
use App\Models\DowntimeRecord;
use App\Services\DowntimeRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DowntimeRecordController extends Controller
{
    public function __construct(
        private readonly DowntimeRecordService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $records = $this->service->getAll(
            filters: $request->only(['type', 'status', 'impact', 'from_date', 'to_date']),
            perPage: $request->integer('per_page', 15)
        );

        return ApiResponse::paginated(
            $records,
            DowntimeRecordResource::collection($records),
            'Downtime records retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDowntimeRecordRequest $request): JsonResponse
    {
        $records = $this->service->store($request->validated());

        return ApiResponse::success(
            new DowntimeRecordResource($records),
            'Downtime record created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(DowntimeRecord $records): JsonResponse
    {
        return ApiResponse::success(
            new DowntimeRecordResource($records->load('reporter')),
            'Downtime record retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDowntimeRecordRequest $request, DowntimeRecord $records): JsonResponse
    {
        $records = $this->service->update($records, $request->validated());

        return ApiResponse::success(
            new DowntimeRecordResource($records),
            'Downtime record updated successfully'
        );
    }

    public function resolve(ResolveDowntimeRecordRequest $request, DowntimeRecord $records): JsonResponse 
    {
        $records = $this->service->resolve($records, $request->validated());

        return ApiResponse::success(
            new DowntimeRecordResource($records),
            'Downtime record resolved successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DowntimeRecord $records): JsonResponse
    {
        $this->service->delete($records);

        return ApiResponse::success(
            null,
            'Downtime record deleted successfully'
        );
    }
}
