<?php

namespace App\Http\Controllers\Api\v1\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\FeatureRequest;
use App\Services\Attachment\AttachmentService;
use App\Traits\HandleAttachments;
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

    public function index(Request $request, FeatureRequest $feature)
    {
        return $this->indexAttachments($request, $feature);
    }

    public function store(Request $request, FeatureRequest $feature)
    {
        return $this->storeAttachments($request, $feature);
    }

    public function destroy(FeatureRequest $feature, Attachment $attachment)
    {
        return $this->destroyAttachments($feature, $attachment);
    }




}
