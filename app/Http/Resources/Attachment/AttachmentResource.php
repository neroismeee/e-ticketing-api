<?php

namespace App\Http\Resources\Attachment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AttachmentResource extends JsonResource
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
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->type,
            'url' => $this->url,
            'commentable_id' => $this->commentable_id,
            'commentable_type' => $this->commentable_type,
            'uploaded_by' => $this->uploaded_by,
            'uploaded_at' => $this->uploaded_at->format('Y-m-d H:i:s'),
        ];
    }
}
