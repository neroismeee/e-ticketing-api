<?php

namespace App\Http\Requests\ErrorReport;

use App\Enums\AssignedTeam;
use App\Enums\ErrorCategory;
use App\Enums\Priorities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'title' => Str::title(trim($this->title)),
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
            'category' => ['required', 'string', Rule::in(ErrorCategory::values())],
            'priority' => ['required', 'string', Rule::in(Priorities::values())],
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => ['nullable', 'string', 'max:255', Rule::in(AssignedTeam::values())],
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'source_ticket_id' => 'nullable|integer|exists:error_reports,id',
            'is_direct_input' => 'required|boolean',
        ];
    }
}
