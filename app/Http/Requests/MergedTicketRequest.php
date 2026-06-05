<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MergedTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'merged_ticket_ids' => ['required', 'array', 'min:1'],
            'merged_ticket_ids.*' => [
                'string',
                Rule::exists('tickets', 'id'),
                Rule::notIn([$this->route('ticket')?->id])
            ]
        ];
    }
}
