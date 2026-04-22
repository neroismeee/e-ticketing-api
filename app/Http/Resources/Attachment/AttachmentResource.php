<?php

namespace App\Http\Resources\Attachment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'attachable' => [
                'type' => $this->attachable_type,
                'id' => $this->attachable_id
            ],
            'uploader' => $this->uploader ? [
                'id' => $this->uploader->id,
                'name' => $this->uploader->name,
                'username' => $this->uploader->username,
            ]: null,
            'uploaded_at' => $this->uploaded_at->format('Y-m-d H:i:s'),
        ];
    }
}
