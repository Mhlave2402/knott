<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftContributionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:1',
            'message' => 'sometimes|string|max:500',
            'anonymous' => 'sometimes|boolean',
        ];
    }
}
