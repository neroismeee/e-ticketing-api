<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'ticket_id' => 'nullable',
            'feature_request_id' => 'nullable',
            'error_report_id' => 'nullable',
            'user_id' => 'required|integer',
            'content' => 'required|string',
            'is_internal' => 'nullable|boolean',
            'created_at' => 'nullable|timestamp',
            'updated_at' => 'nullable|timestamp'
        ];
    }
}
