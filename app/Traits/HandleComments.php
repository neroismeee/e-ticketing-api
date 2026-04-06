<?php

namespace App\Traits;

use App\Helpers\ApiResponse;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

trait HandleComments
{
    public function indexComment(Model $parent)
    {
        $comments = $parent->comments()
            ->with('user')
            ->latest()
            ->paginate(10);

        return CommentResource::collection($comments);
    }

    public function storeComment(StoreCommentRequest $request, Model $parent)
    {
        $comment = $parent->comments()->create([
            ...$request->validated(),
            'user_id' => Auth::id(),
            'is_internal' => $this->resolveIsInternal($request),
        ]);

        return new CommentResource($comment->load('user'));
    }

    public function destroyComment(Model $parent, Comment $comment): JsonResponse
    {
        $morphAlias = Relation::getMorphAlias(get_class($parent));

        if ($comment->commentable_id !== $parent->getKey() || $comment->commentable_type !== $morphAlias) {
            abort(403, 'This comment is not owned by that resource');
        }

        $comment->delete();

        return ApiResponse::success(
            null,
            'Comment deleted successfully'
        );
    }

    // Helpers
    private function resolveIsInternal(StoreCommentRequest $request): bool
    {
        $user = $request->user();

        if ($user && $user->isItStaff()) {
            return true;
        }

        return $request->boolean('is_internal');
    }
}
