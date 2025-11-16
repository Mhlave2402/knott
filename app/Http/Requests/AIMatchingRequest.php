<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AIMatchingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'budget_range' => 'required|string',
            'preferred_styles' => 'required|array',
            'location_preferences' => 'required|array',
            'vendor_types' => 'required|array',
        ];
    }
}
