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
            'ticket_id' => $this->ticket_id,
            'error_report_id' => $this->error_report_id,
            'feature_request_id' => $this->feature_request_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'is_internal' => $this->is_internal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
