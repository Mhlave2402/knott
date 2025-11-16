<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public contributions allowed
    }

    public function rules(): array
    {
        return [
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:10|max:50000',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'guest_name.required' => 'Please provide your name.',
            'guest_email.required' => 'Email address is required.',
            'guest_email.email' => 'Please provide a valid email address.',
            'amount.required' => 'Contribution amount is required.',
            'amount.min' => 'Minimum contribution is R10.',
            'amount.max' => 'Maximum contribution is R50,000.',
        ];
    }
} 