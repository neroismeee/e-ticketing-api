<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreTicketRequest extends FormRequest
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
        $this->merge([
            'title' => Str::title(trim($this->title))
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
            'category' => 'required|string|in:' . implode(',', Ticket::CATEGORIES),
            'priority' => 'required|string|in:' . implode(',', Ticket::PRIORITIES),
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', Ticket::ASSIGNED_TEAMS),
            'due_date' => 'nullable|date',
            'response_time' => 'nullable|numeric|decimal:0,2',
            'resolution_time' => 'nullable|numeric|decimal:0,2',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'parent_ticket_id' => 'nullable|string|exists:tickets,id',
        ];
    }
}
