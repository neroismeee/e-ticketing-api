<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'id'=> $this->id,
            'ticket_id'=> $this->ticket_id,
            'error_report_id'=> $this->error_report_id,
            'feature_request_id'=> $this->feature_request_id,
            'previous_status'=> $this->previous_status,
            'new_status'=> $this->new_status
        ]);
    }
}
