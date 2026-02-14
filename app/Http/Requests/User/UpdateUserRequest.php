<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $this->user,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|in:' . implode(',', User::ROLES),      
            'team' => 'nullable|string|max:255|in:' . implode(',', User::TEAMS),
            'avatar' => 'nullable|url',
            'is_active' => 'boolean|default:1',
            'pref_email_notifications' => 'nullable|boolean',
            'pref_sla_alerts' => 'nullable|boolean',
            'pref_downtime_alerts' => 'nullable|boolean',
            'pref_digest_frequency' => 'nullable|string|in:' . implode(',', User::PREF_DIGEST_FREQUENCIES),
            'pref_quiet_hours' => 'nullable|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/'
        ];
    }
}
