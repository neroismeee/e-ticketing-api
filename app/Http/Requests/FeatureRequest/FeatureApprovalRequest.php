<?php

namespace App\Http\Requests\FeatureRequest;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeatureApprovalRequest extends FormRequest
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
            'approved_by' => Auth::id(),
            'approval_date' => Carbon::now()
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
            'status' => 'required|string|in:approved,rejected',
            'rejection_reason' => [
                Rule::requiredIf(fn() => $this->status === 'rejected'),
                'nullable',
                'string'
            ],
            'approved_by' => 'required|integer|exists:users,id',
            'approval_date' => 'required|date'
        ];
    }
}
