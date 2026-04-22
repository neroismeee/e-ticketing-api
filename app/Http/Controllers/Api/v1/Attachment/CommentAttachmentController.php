<?php

namespace App\Http\Controllers\Api\v1\Attachment;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use App\Services\Attachment\AttachmentService;
use App\Traits\HandleAttachments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentAttachmentController extends Controller
{
    use HandleAttachments;

    public function __construct(
        protected AttachmentService $attachmentService
    ) {}

    private function getAttachmentService(): AttachmentService
    {
        return $this->attachmentService;
    }

    public function index(Request $request, Comment $comment): JsonResponse
    {
        return $this->indexAttachments($request, $comment);
    }

    public function store(Request $request, Comment $comment): JsonResponse
    {
        return $this->storeAttachments($request, $comment);
    }

    public function destroy(Comment $comment, Attachment $attachment): JsonResponse
    {
        return $this->destroyAttachments($comment, $attachment);
    }
}
