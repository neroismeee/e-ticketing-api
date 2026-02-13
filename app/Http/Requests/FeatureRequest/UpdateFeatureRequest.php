<?php

namespace App\Http\Requests\FeatureRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FeatureRequest;

class UpdateFeatureRequest extends FormRequest
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
            'request_type' => 'sometimes|string|in:' . implode(',', FeatureRequest::REQUEST_TYPES),
            'priority' => 'sometimes|string|in:' . implode(',', FeatureRequest::PRIORITIES),
            'status' => 'sometimes|string|in:' . implode(',', FeatureRequest::STATUSES),
            'progress' => 'sometimes|integer|min:0|max:100',
            'reporter_id' => 'sometimes|integer',
            'assigned_to_id' => 'nullable|integer',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', FeatureRequest::TEAMS),
            'date_submitted' => 'sometimes|date',
            'approval_date' => 'nullable|date',
            'assignment_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'estimated_effort' => 'nullable|integer',
            'actual_effort' => 'nullable|integer',
            'sla_time_elapsed' => 'nullable|integer',
            'sla_time_remaining' => 'nullable|integer',
            'sla_breached' => 'sometimes|boolean',
            'approved_by' => 'nullable|string|max:255',
            'rejection_reason' => 'nullable|string|max:500',
            'roi_impact' => 'nullable|string',
            'quality_impact' => 'nullable|string',
            'post_implementation_notes' => 'nullable|string',
            'source_ticket_id' => 'nullable|integer',
            'is_direct_input' => 'sometimes|boolean',
        ];
    }
}
