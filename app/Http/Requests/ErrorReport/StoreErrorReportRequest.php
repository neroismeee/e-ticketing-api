<?php

namespace App\Http\Requests\ErrorReport;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ErrorReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'category' => 'required|string|in:' . implode(',', ErrorReport::CATEGORIES),
            'priority' => 'required|string|in:' . implode(',', ErrorReport::PRIORITIES),
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', ErrorReport::TEAMS),
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'source_ticket_id' => 'nullable|integer|exists:error_reports,id',
            'is_direct_input' => 'required|boolean',
        ];
    }
}
