<?php

namespace App\Http\Controllers\Api\v1\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\ErrorReport;
use App\Services\Comment\CommentService;

class ErrorReportCommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService,
    ) {}

    public function index(ErrorReport $error)
    {
        return $this->commentService->indexComment($error);
    }

    public function store(StoreCommentRequest $request, ErrorReport $error)
    {
        return $this->commentService->storeComment($request, $error);
    }

    public function destroy(ErrorReport $error, Comment $comment)
    {
        return $this->commentService->destroyComment($error, $comment);
    }
}
