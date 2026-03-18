<?php

namespace App\Http\Resources\FeatureRequest;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
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
            'status' => $this->status,
            'approved_by'=> $this->approved_by,
            'approved_date' => Carbon::now()->toDateString(),
            'rejection_reason' => $this->rejection_reason

        ];
    }
}
