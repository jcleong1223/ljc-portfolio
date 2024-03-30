<?php

namespace App\Http\Requests\Admin\ProductContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SyncImageFormRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'id' => ['required','integer'],
            'image' => ['required', 'file', 'max:10240', 'mimes:jpeg,jpg,png'],
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
