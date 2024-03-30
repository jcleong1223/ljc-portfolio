<?php

namespace App\Http\Requests\Admin\ProductContent;

use App\Models\ProductContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFormRequest extends FormRequest
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
            'media_type' => ['required','integer', Rule::in([ ProductContent::TYPE_IMAGE])],
			'seq_value' => ['nullable', 'integer', 'between:0,100'],
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
