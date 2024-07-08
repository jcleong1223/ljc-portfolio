<?php

namespace App\Http\Requests\Admin\Project;

use App\Rules\FileOrElse;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectFormRequest extends FormRequest
{
	protected function prepareForValidation()
	{
		// $this->merge([
		// 	'specifications' => json_decode($this->specifications, true),
		// 	'product_category_ids' => json_decode($this->product_category_ids, true),
		// ]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id' => ['required', 'integer'],
			'title' => ['required', 'max:100'],
			'website_url' => ['nullable', 'max:150'],
			'short_description' => ['required', 'max:300'],
			'description' => ['required', 'max:1500'],
			'status' => ['required', 'in:0,1'],
			'seq_value' => ['required', 'integer', 'min:1'],
			'media_contents' => ['nullable', 'array'],
			'media_contents.*' => ['required', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			'web_image' => ['nullable', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			'tags' => ['nullable', 'array'],
			'project_date' => ['nullable'],
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
			'seq_value.required' => 'The Sequence field is required',
			'seq_value.integer' => 'The Sequence field must be an integer',
			'seq_value.min' => 'The Sequence field must be at least 1',
		];
	}
}
