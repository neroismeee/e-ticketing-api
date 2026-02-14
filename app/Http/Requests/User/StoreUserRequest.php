<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user,
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:' . implode(',', User::ROLES),      
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
