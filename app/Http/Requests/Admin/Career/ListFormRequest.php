<?php

namespace App\Http\Requests\Admin\Career;

use Illuminate\Foundation\Http\FormRequest;

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
            "activity" => ['sometimes', 'integer'],

            "page" => ["sometimes", "integer"],
            "itemsPerPage" => ["sometimes", "integer"],
            "sortBy" => ["sometimes", "string"],
            "sortDesc" => ["sometimes", "boolean"],
            "search" => ["sometimes", 'nullable', "string"],
            "searchBy" => ["sometimes", "string"]
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
