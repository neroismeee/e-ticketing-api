<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'status' => 'pending_approval',
            'reporter_id' => Auth::id(),
            'date_reported' => Carbon::now(),
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
            'status' => 'required|string|in:' . implode(',', Ticket::STATUSES),
            'reporter_id' => 'required|integer|exists:users,id',
            'assigned_to_id' => 'nullable|integer|exists:users,id',
            'assigned_team' => 'nullable|string|max:255|in:' . implode(',', Ticket::ASSIGNED_TEAMS),
            'date_reported' => 'required|date',
            'due_date' => 'nullable|date',
            'response_time' => 'nullable|numeric|decimal:0,2',
            'resolution_time' => 'nullable|numeric|decimal:0,2',
            'estimated_effort' => 'nullable|numeric|decimal:0,2',
            'parent_ticket_id' => 'nullable|string|exists:tickets,id',
        ];
    }
}
