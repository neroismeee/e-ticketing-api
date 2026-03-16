<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ErrorReport;
use App\Models\Ticket;

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
        $ticket = Ticket::find($this->route('ticket'));
        
        $this->merge([
            'status' => 'in_progress',
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
            'category' => 'required|string|in:' . implode(',', ErrorReport::CATEGORIES),
            'priority' => 'required|string|in:' . implode(',', ErrorReport::PRIORITIES),
            'status' => 'required|string|in:' . implode(',', ErrorReport::STATUSES),
            'progress' => 'required|integer|min:0|max:100',
            'reporter_id' => 'required|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', ErrorReport::TEAMS),
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
