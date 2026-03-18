<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    protected string $sourceTicketId;
    protected string $convertedType;
    
    public function __construct($resource, string $sourceTicketId, string $convertedType)
    {
        parent::__construct($resource);
        $this->sourceTicketId = $sourceTicketId;
        $this->convertedType = $convertedType;
    }

    public function toArray(Request $request): array
    {
        return [
            'source_ticket_id' => $this->sourceTicketId,
            'converted_to' => [
                'type' => $this->convertedType,
                'id' => $this->resource->id
            ]
        ];
    }
}
