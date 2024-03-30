<?php

namespace App\Http\Requests\Web\Career;

use App\Rules\FileOrElse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendResumeRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            "careerId" => ["required", "integer"],
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "phone" => ["required", 'regex:/^[0-9+\-]+$/'],
            "position_applied" => ["required", "string"],
            "resumeFile" => ["required", new FileOrElse(['max:10240', 'mimes:pdf'], [])],
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
