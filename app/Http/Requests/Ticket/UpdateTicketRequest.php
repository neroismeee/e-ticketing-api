<?php

namespace App\Http\Requests\Ticket;

use App\Enums\AssignedTeam;
use App\Enums\ConversionTypes;
use App\Enums\Priorities;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;
use Illuminate\Validation\Rule;
use App\Enums\TicketCategory;
use App\Enums\TicketStatus;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => ['required', 'string', Rule::in(TicketCategory::values())],  
            'priority' => ['required', 'string', Rule::in(Priorities::values())],  
            'status' => ['required', 'string', Rule::in(TicketStatus::values())],  
            'reporter_id' => 'sometimes|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => ['required', 'string', Rule::in(AssignedTeam::values())],  
            'date_reported' => 'sometimes|date',
            'due_date' => 'nullable|date',
            'resolved_date' => 'nullable|date',
            'closed_date' => 'nullable|date',
            'sla_breached' => 'sometimes|boolean',
            'response_time' => 'nullable|numeric|decimal:0,2',
            'resolution_time' => 'nullable|numeric|decimal:0,2',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'actual_effort' => 'nullable|numeric|decimal:0,2',
            'parent_ticket_id' => 'nullable|integer|exists:tickets,id',
            'converted_to_type' => ['required', 'string', Rule::in(ConversionTypes::values())],  
            'converted_to_id' => 'nullable|integer',
            'converted_at' => 'nullable|date',
            'conversion_reason' => 'nullable|string|max:255',
        ];
    }
}
