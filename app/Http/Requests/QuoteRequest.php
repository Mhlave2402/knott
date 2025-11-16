<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_id' => 'required|exists:vendor_services,id',
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'special_requests' => 'sometimes|string|max:1000',
        ];
    }
}
