<?php

namespace App\Http\Requests\Web\ContactUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendEmailRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "phone" => ["required", 'regex:/^[0-9+\-]+$/'],
            "subject" => ["required", "string"],
            // "phone_prefix" => ["nullable", "string"],
            "message" => ["required", "string"],
        ];
    }

    /**
    * Custom message for validation
    *
    * @return array
    */
    public function messages()
    {
        return [
            // 'firstName.required' => 'Page\'s Title field is required.',
        ];

    }
}
