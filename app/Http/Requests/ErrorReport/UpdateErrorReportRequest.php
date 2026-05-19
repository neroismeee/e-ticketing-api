<?php

namespace App\Http\Requests\ErrorReport;

use App\Enums\AssignedTeam;
use App\Enums\Priorities;
use App\Enums\TicketCategory;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateErrorReportRequest extends FormRequest
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
            'category' => ['sometimes', 'string', Rule::in(TicketCategory::values())],
            'priority' => ['sometimes', 'string', Rule::in(Priorities::values())],
            'status' => ['sometimes', 'string', Rule::in(TicketStatus::values())],
            'reporter_id' => 'sometimes|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => ['nullable', 'string', 'max:255', Rule::in(AssignedTeam::values())],
            'date_reported' => 'sometimes|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'actual_effort' => 'nullable|numeric|decimal:0,2',
            'sla_time_elapsed' => 'nullable|numeric|decimal:0,2',
            'sla_time_remaining' => 'nullable|numeric|decimal:0,2',
            'sla_breached' => 'sometimes|boolean',
            'source_ticket_id' => 'nullable|integer|exists:error_reports,id',
            'is_direct_input' => 'sometimes|boolean',
        ];
    }
}
