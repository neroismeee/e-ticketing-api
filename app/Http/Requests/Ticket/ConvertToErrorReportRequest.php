<?php

namespace App\Http\Requests\Ticket;

use App\Enums\AssignedTeam;
use App\Enums\Priorities;
use App\Enums\TicketCategory;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConvertToErrorReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $ticket = $this->route('ticket');
        
        $this->merge([
            'status' => TicketStatus::PendingApproval,
            'progress' => 0,
            'reporter_id' => $ticket->reporter_id,
            'date_reported' =>$ticket->date_reported,
            'is_direct_input' => false
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => ['required', 'string', Rule::in(TicketCategory::values())],
            'priority' => ['required', 'string', Rule::in(Priorities::values())],
            'status' => ['required', 'string', Rule::in(TicketStatus::values())],
            'progress' => 'required|integer|min:0|max:100',
            'reporter_id' => 'required|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => ['nullable', 'string', 'max:255', Rule::in(AssignedTeam::values())],
            'date_reported' => 'required|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'source_ticket_id' => 'nullable|integer|exists:error_reports,id',
            'is_direct_input' => 'required|boolean',
            'conversion_reason' => 'required|string'
        ];
    }
}
