<?php

/**
 * ==============================================
 * FORM REQUESTS
 * ==============================================
 * Location: app/Http/Requests/QuoteRequestRequest.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('couple');
    }

    public function rules(): array
    {
        return [
            'budget' => 'required|numeric|min:1000|max:10000000',
            'guest_count' => 'required|integer|min:10|max:1000',
            'location' => 'required|string|max:255',
            'preferred_date' => 'nullable|date|after:today',
            'style' => 'required|in:vintage,modern,rustic,elegant,traditional,bohemian,minimalist,glamorous',
            'special_requirements' => 'nullable|string|max:1000',
            'urgency' => 'required|in:flexible,moderate,urgent',
            'contact_preference' => 'required|in:email,phone,whatsapp'
        ];
    }

    public function messages(): array
    {
        return [
            'budget.required' => 'Please specify your wedding budget.',
            'budget.min' => 'Budget must be at least R1,000.',
            'guest_count.required' => 'Please specify the number of guests.',
            'guest_count.min' => 'Guest count must be at least 10.',
            'location.required' => 'Please specify your wedding location.',
            'style.required' => 'Please select your preferred wedding style.',
            'urgency.required' => 'Please specify your timeline urgency.',
            'contact_preference.required' => 'Please select how vendors should contact you.'
        ];
    }
}

/**
 * Location: app/Http/Requests/QuoteResponseRequest.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('vendor');
    }

    public function rules(): array
    {
        return [
            'quote_amount' => 'required|numeric|min:100|max:10000000',
            'package_name' => 'required|string|max:255',
            'package_description' => 'required|string|max:2000',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'includes' => 'nullable|array',
            'includes.*' => 'string|max:255',
            'excludes' => 'nullable|array',
            'excludes.*' => 'string|max:255',
            'custom_message' => 'nullable|string|max:1000',
            'payment_terms' => 'required|string|max:500',
            'availability_notes' => 'nullable|string|max:500',
            'quote_validity_days' => 'required|integer|min:7|max:90',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120' // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'quote_amount.required' => 'Please specify your quote amount.',
            'quote_amount.min' => 'Quote amount must be at least R100.',
            'package_name.required' => 'Please provide a package name.',
            'package_description.required' => 'Please describe your package.',
            'payment_terms.required' => 'Please specify your payment terms.',
            'quote_validity_days.required' => 'Please specify quote validity period.',
            'attachments.*.max' => 'Each attachment must not exceed 5MB.',
            'attachments.*.mimes' => 'Attachments must be PDF, image, or document files.'
        ];
    }
}