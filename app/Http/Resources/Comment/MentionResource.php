<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment_id' => $this->comment_id,
            'user' => $this->whenLoaded('mentionedUser', function () {
                return [
                    'id' => $this->mentionedUser->id,
                    'username' => $this->mentionedUser->username,
                    'name' => $this->mentionedUser->name,
                ];
            }),
            'comment' => $this->whenLoaded('comment', function () {
                return [
                    'commentable_id' => $this->comment->commentable_id,
                    'commentable_type' => $this->comment->commentable_type,
                    'content' => $this->comment->content,
                    'created_at' => $this->comment->created_at->format('Y-m-d H:i:s')
                ];
            })
        ];
    }
}
