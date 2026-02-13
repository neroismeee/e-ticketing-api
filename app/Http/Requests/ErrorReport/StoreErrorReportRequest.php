<?php

namespace App\Http\Requests\ErrorReport;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ErrorReport;

class StoreErrorReportRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:' . implode(',', ErrorReport::CATEGORIES),
            'priority' => 'required|string|in:' . implode(',', ErrorReport::PRIORITIES),
            'status' => 'required|string|in:' . implode(',', ErrorReport::STATUSES),
            'reporter_id' => 'required|integer',
            'assigned_to_id' => 'nullable|integer',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', ErrorReport::TEAMS),
            'date_reported' => 'required|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'estimated_effort' => 'nullable|integer',
            'actual_effort' => 'nullable|integer',
            'sla_time_elapsed' => 'nullable|integer',
            'sla_time_remaining' => 'nullable|integer',
            'sla_breached' => 'required|boolean',
            'source_ticket_id' => 'nullable|integer',
            'is_direct_input' => 'required|boolean',
        ];
    }
}
