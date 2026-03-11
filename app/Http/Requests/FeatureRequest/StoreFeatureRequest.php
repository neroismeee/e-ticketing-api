<?php

namespace App\Http\Requests\FeatureRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FeatureRequest;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class StoreFeatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'reporter_id' => $this->user()->id,
            'date_submitted' => Carbon::now(),
            'status' => 'submission',
            'progress' => 0,
            'is_direct_input' => !$this->has('source_ticket_id') || is_null($this->source_ticket_id)
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
            'request_type' => 'required|string|in:' . implode(',', FeatureRequest::REQUEST_TYPES),
            'priority' => 'required|string|in:' . implode(',', FeatureRequest::PRIORITIES),
            'status' => 'required|string|in:' . implode(',', FeatureRequest::STATUSES),
            'progress' => 'required|integer|min:0|max:100',
            'reporter_id' => 'required|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', FeatureRequest::TEAMS),
            'assignment_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'estimated_effort' => 'nullable|integer',
            'roi_impact' => 'nullable|string',
            'quality_impact' => 'nullable|string',
            'source_ticket_id' => 'nullable|integer|exists:feature_requests,id',
            'is_direct_input' => 'required|boolean',
        ];
    }
}
