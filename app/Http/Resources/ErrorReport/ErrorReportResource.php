<?php

namespace App\Http\Resources\ErrorReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorReportResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'category' => [
                'value' => $this->category->value,
                'label' => $this->category->label()
            ],
            'priority' => [
                'value' => $this->priority->value,
                'label' => $this->priority->label()
            ],
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label()
            ],
        ];
    }
}
