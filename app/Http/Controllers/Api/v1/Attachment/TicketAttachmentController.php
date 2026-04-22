<?php

namespace App\Http\Controllers\Api\v1\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Ticket;
use App\Services\Attachment\AttachmentService;
use App\Traits\HandleAttachments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketAttachmentController extends Controller
{
    use HandleAttachments;

    public function __construct(
        protected AttachmentService $attachmentService
    ) {}

    protected function getAttachmentService(): AttachmentService
    {
        return $this->attachmentService;
    }

    public function index(Request $request, Ticket $ticket): JsonResponse
    {
        return $this->indexAttachments($request, $ticket);
    }

    public function store(Request $request, Ticket $ticket): JsonResponse
    {
        return $this->storeAttachments($request, $ticket);
    }

    public function destroy(Ticket $ticket, Attachment $attachment): JsonResponse
    {
        return $this->destroyAttachments($ticket, $attachment);
    }
}
