<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentDetailResource extends JsonResource
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
            'commentable_id' => $this->commentable_id,
            'commentable_type' => $this->commentable_type,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'is_internal' => $this->is_internal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
