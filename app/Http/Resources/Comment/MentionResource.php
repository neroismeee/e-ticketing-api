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
            })
        ];
    }
}
