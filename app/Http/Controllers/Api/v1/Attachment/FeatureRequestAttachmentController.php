<?php

namespace App\Http\Controllers\Api\v1\Attachment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\StoreAttachmentRequest;
use App\Models\Attachment;
use App\Models\FeatureRequest;
use App\Services\Attachment\AttachmentService;
use App\Traits\HandleAttachments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeatureRequestAttachmentController extends Controller
{
    use HandleAttachments;

    public function __construct(
        protected AttachmentService $attachmentService
    ) {}

    protected function getAttachmentService(): AttachmentService
    {
        return $this->attachmentService;
    }

    public function index(Request $request, FeatureRequest $feature): JsonResponse
    {
        return $this->indexAttachments($request, $feature);
    }

    public function store(StoreAttachmentRequest $request, FeatureRequest $feature): JsonResponse
    {
        return $this->storeAttachments($request, $feature);
    }

    public function destroy(FeatureRequest $feature, Attachment $attachment): JsonResponse
    {
        return $this->destroyAttachments($feature, $attachment);
    }




}
