<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\AssignedTeam;

class AssignmentResource extends JsonResource
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
            'status' => $this->status instanceof \BackedEnum
                ? $this->status->value
                : $this->status,
            'assigned_user' => $this->assignedUser ? [
                'id' => $this->assignedUser->id,
                'name' => $this->assignedUser->name,
                'username' => $this->assignedUser->username
            ]: null,
            'assigned_team' => $this->assigned_team 
            ? [
                'value' => $this->assigned_team->value,
                'label' => $this->assigned_team->label(),
            ]: null,
        ];
    }
}
