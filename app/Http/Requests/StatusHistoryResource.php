<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusHistoryResource extends FormRequest
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
            'ticket_id' => 'nullable|integer',
            'error_report_id' => 'nullable|integer',
            'feature_request_id' => 'nullable|integer',
            'previous_status' => 'required|string|max:255',
            'new_status' => 'required|string|max:255',
            'changed_by' => 'required|integer',
            'changed_at' => 'date',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
