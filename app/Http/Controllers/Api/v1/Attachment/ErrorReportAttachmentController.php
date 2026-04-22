<?php

namespace App\Http\Controllers\Api\v1\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ErrorReport;
use App\Services\Attachment\AttachmentService;
use App\Traits\HandleAttachments;
use Illuminate\Http\Request;

class ErrorReportAttachmentController extends Controller
{
    use HandleAttachments;

    public function __construct(
        protected AttachmentService $attachmentService
    ) {}

    private function getAttachmentService(): AttachmentService
    {
        return $this->attachmentService;
    }

    public function index(Request $request, ErrorReport $error)
    {
        return $this->indexAttachments($request, $error);
    }

    public function store(Request $request, ErrorReport $error)
    {
        return $this->storeAttachments($request, $error);
    }

    public function destroy(ErrorReport $error, Attachment $attachment)
    {
        return $this->destroyAttachments($error, $attachment);
    }
}
