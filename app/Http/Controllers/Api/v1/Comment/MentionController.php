<?php

namespace App\Http\Controllers\api\v1\Comment;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\MentionResource;
use App\Models\CommentMention;
use Illuminate\Http\JsonResponse;

class MentionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $mentions = CommentMention::with([
            'comment_id',
            'user_id'
        ])->latest()
            ->paginate(10);

        return ApiResponse::paginated(
            $mentions,
            MentionResource::collection($mentions),
            'Comment Mentions Retrieved Successfully'
        );
    }

    public function mine()
    {
        
    }
}
