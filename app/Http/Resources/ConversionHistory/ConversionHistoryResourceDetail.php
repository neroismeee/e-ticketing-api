<?php

namespace App\Http\Resources\ConversionHistory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\ConversionTypes;
use App\Models\FeatureRequest;
use App\Models\ErrorReport;

class ConversionHistoryResourceDetail extends JsonResource
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
            'source_ticket' => [
                'id' => $this->sourceTicket->id,
                'title' => $this->sourceTicket->title,
                'status' => $this->sourceTicket->status,
            ],
            'target' => [
                'type' => $this->target_type->value,
                'label' => $this->target_type->label(),
                'id' => $this->target_id,
                'detail' => $this->resolveTargetDetail(),
            ],
            'converted_by' => $this->converter ? [
                'id' => $this->converter->id,
                'name' => $this->converter->name,
                'username' => $this->converter->username
            ] : null,
            'converted_at' => $this->converted_at?->format('Y-m-d H:i:s'),
            'reason' => $this->reason,
            'notes' => $this->notes,
        ];
    }

    // Helpers
    private function resolveTargetDetail(): ?array
    {
        if (is_null($this->target_type) || is_null($this->target_id)) {
            return null;
        }

        $target = match ($this->target_type) {
            ConversionTypes::FeatureRequest => FeatureRequest::find($this->target_id),
            ConversionTypes::ErrorReport => ErrorReport::find($this->target_id),
            default => null,
        };

        return $target ? ['id' => $target->id, 'title' => $target->title] : null;
    }
}
