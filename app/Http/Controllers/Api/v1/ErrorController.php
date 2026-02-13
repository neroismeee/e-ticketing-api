<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorReport\StoreErrorReportRequest;
use App\Http\Requests\ErrorReport\UpdateErrorReportRequest;
use App\Models\ErrorReport;
use App\Http\Resources\ErrorDetailResource;
use App\Http\Resources\ErrorResource;

class ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $error = ErrorReport::with(['reporter', 'assignee'])
            ->latest()
            ->paginate(10);

        return ApiResponse::paginated(
            $error,
            ErrorResource::collection($error),
            'Error Report retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreErrorReportRequest $request)
    {
        $error = ErrorReport::create($request->validated());

        return ApiResponse::success(
            new ErrorDetailResource($error),
            'Error Report created successfully'
        );
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ErrorReport $error)
    {
        $error->load(['reporter', 'assignee']);

        return ApiResponse::success(
            new ErrorDetailResource($error),
            'Error Report retrieved successfully',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateErrorReportRequest $request, ErrorReport $error)
    {
        $error->update($request->validated());

        return ApiResponse::success(
            new ErrorDetailResource($error),
            'Error Report updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ErrorReport $error)
    {
        $error->delete();

        return ApiResponse::success(
            null,
            'Error Report deleted successfully',
        );
    }
}
