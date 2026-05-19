<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectRequest;
use App\Models\ErrorReport;
use App\Models\FeatureRequest;
use App\Models\Ticket;
use App\Services\ApprovalService;
use App\Traits\HandleApproval;
use Illuminate\Http\JsonResponse;

class ApprovalController extends Controller
{
    use HandleApproval;

    public function __construct(
        protected ApprovalService $approvalService
    ) {}

    protected function getApprovalService(): ApprovalService
    {
        return $this->approvalService;
    }

    public function approveTicket(Ticket $ticket): JsonResponse
    {
        return $this->approve($ticket);
    }

    public function rejectTicket(RejectRequest $request, Ticket $ticket): JsonResponse
    {
        return $this->reject($request, $ticket);
    }

    public function approveFeatureRequest(FeatureRequest $feature): JsonResponse
    {
        return $this->approve($feature);
    }

    public function rejectFeatureRequest(RejectRequest $request, FeatureRequest $feature): JsonResponse
    {
        return $this->reject($request, $feature);
    }

    public function approveErrorReport(ErrorReport $error): JsonResponse
    {
        return $this->approve($error);
    }

    public function rejectErrorReport(RejectRequest $request, ErrorReport $error): JsonResponse
    {
        return $this->reject($request, $error);
    }
}
