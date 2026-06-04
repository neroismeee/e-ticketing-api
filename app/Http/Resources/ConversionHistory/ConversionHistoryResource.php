<?php

namespace App\Http\Resources\ConversionHistory;

use App\Enums\ConversionTypes;
use App\Models\ErrorReport;
use App\Models\FeatureRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversionHistoryResource extends JsonResource
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
            'source_ticket' => $this->sourceTicket->id,
            'target_type' => $this->target_type->value,
            'converted_by' => $this->converter->name,
            'converted_at' => $this->converted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
