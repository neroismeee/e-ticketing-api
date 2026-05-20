<?php

namespace App\Http\Controllers\Api\v1\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\FeatureRequest;
use App\Services\Comment\CommentService;

class FeatureRequestCommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function index(FeatureRequest $feature)
    {
        return $this->commentService->indexComment($feature);
    }

    public function store(StoreCommentRequest $request, FeatureRequest $feature)
    {
        return $this->commentService->storeComment($request, $feature);
    }

    public function destroy(FeatureRequest $feature, Comment $comment)
    {
        return $this->commentService->destroyComment($feature, $comment);
    }
}
