<?php

namespace App\Http\Requests\Admin\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListFormRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            "activity" => ['nullable', 'integer'],
			"exclude_ids" => ['nullable', 'array'],

            "page" => ["nullable", "integer"],
            "itemsPerPage" => ["nullable", "integer"],
            "sortBy" => ["nullable", "string"],
            "sortDesc" => ["nullable", "boolean"],
            "search" => ["nullable", 'nullable', "string"],
            "searchBy" => ["nullable", "string"],
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
