<?php

namespace App\Http\Requests\Admin\Tag;

use App\Rules\FileOrElse;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTagFormRequest extends FormRequest
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
			'level' => ['required', 'integer'],
			'status' => ['required', 'in:0,1'],
			'seq_value' => ['required', 'integer', 'min:1'],
			'web_image' => ['nullable', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			// 'icon' => ['nullable', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
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
