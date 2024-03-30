<?php

namespace App\Http\Requests\Admin\ProductContent;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'product_id' => ['required', 'integer'],
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
		];
	}
}
