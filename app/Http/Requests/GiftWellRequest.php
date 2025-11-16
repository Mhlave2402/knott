<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftWellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('couple');
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'target_amount' => 'nullable|numeric|min:100|max:1000000',
            'wedding_date' => 'required|date|after:today',
            'is_public' => 'boolean',
            'thank_you_message' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for your Gift Well.',
            'wedding_date.required' => 'Wedding date is required.',
            'wedding_date.after' => 'Wedding date must be in the future.',
            'target_amount.min' => 'Target amount must be at least R100.',
            'target_amount.max' => 'Target amount cannot exceed R1,000,000.',
        ];
    }
}