<?php

namespace App\Http\Requests\Admin\Product;

use App\Rules\Decimal;
use App\Rules\FileOrElse;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductFormRequest extends FormRequest
{
	protected function prepareForValidation()
	{
		$this->merge([
			'specifications' => json_decode($this->specifications, true),
			'product_category_ids' => json_decode($this->product_category_ids, true),
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => ['required', 'max:100'],
			'price' => ['required', 'min:0', new Decimal(12, 2)],
			'description' => ['required', 'max:300'],
			'image' => ['required', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			'file' => ['nullable', new FileOrElse(['max:10240', 'mimes:pdf'], [])],
			'media_contents' => ['nullable', 'array'],
			'media_contents.*' => ['required', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			'specifications' => ['required', 'array'],
			'specifications.*.title' => ['required', 'string', 'max:150'],
			'specifications.*.value' => ['required', 'string', 'max:150'],
			'product_category_ids' => ['required', 'array'],
			'product_category_ids.*' => ['required', 'integer'],
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
			'product_category_id.required' => 'The category field is required',
		];
	}
}
