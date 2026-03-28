<?php

namespace App\Http\Controllers\api\v1\Comment;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\MentionResource;
use App\Models\CommentMentions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $mention = CommentMentions::with([
            'comment_id',
            'user_id'
        ])->latest()
          ->paginate(10);

        return ApiResponse::paginated(
            $mention,
            MentionResource::collection($mention),
            'Comment Mentions Retrieved Successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
