<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentDetailResource;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::with([
            'ticket',
            'feature_request',
            'error_report',
            'user',
        ])->latest()
          ->paginate(10);

        return ApiResponse::paginated(
            $comment,
            CommentResource::collection($comment),
            'Comment data retrieved successfully'
        );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        
        return ApiResponse::success(
            new CommentDetailResource($comment),
            'Comment created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment->load([
            'ticket',
            'feature_request',
            'error_report',
            'user',
        ]);

        return ApiResponse::success(
            new CommentDetailResource($comment),
            'Comment retrieved successfully'
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return ApiResponse::success(
            new CommentDetailResource($comment),
            'Comment updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return ApiResponse::success(
            null,
            'Comment deleted successfully'
        );
    }
}
