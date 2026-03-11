<?php

namespace App\Http\Requests\ErrorReport;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ErrorReport;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class StoreErrorReportRequest extends FormRequest
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
            'date_reported' => Carbon::now(),
            'status' => 'pending_approval',
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
        ];
    }
}
