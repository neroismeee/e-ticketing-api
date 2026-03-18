<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorReport\StoreErrorReportRequest;
use App\Http\Requests\ErrorReport\UpdateErrorReportRequest;
use App\Models\ErrorReport;
use App\Http\Resources\ErrorDetailResource;
use App\Http\Resources\ErrorResource;
use App\Services\ErrorReportService;
use Illuminate\Http\JsonResponse;
class ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
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
    public function __construct(private ErrorReportService $service){}

    public function store(StoreErrorReportRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $this->service->generateErrorReportId();

        $error = ErrorReport::create($data);

        return ApiResponse::success(
            new ErrorDetailResource($error),
            'Error Report created successfully',
            201
        );
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ErrorReport $error): JsonResponse
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
    public function update(UpdateErrorReportRequest $request, ErrorReport $error): JsonResponse
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
    public function destroy(ErrorReport $error): JsonResponse
    {
        $error->delete();

        return ApiResponse::success(
            null,
            'Error Report deleted successfully',
        );
    }
}
