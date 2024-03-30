<?php

namespace App\Http\Requests\Admin\Career;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerFormRequest extends FormRequest
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
			'location' => ['required', 'max:300'],
			'description' => ['required', 'max:500'],
			'salary_range' => ['required', 'max:500'],
			'exp_required' => ['required', 'integer', 'min:0'],
			'type' => ['required', 'max:500'],
			'status' => ['required', 'integer', 'in:0,1'],
			'seq_value' => ['required', 'integer', 'min:1'],
			'career_level' => ['required', 'max:500'],
			'specializations' => ['required', 'max:500'],
			'qualifications' => ['required', 'max:500'],
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
			'exp_required.required' => 'The Years of Experience field is required',
			'exp_required.integer' => 'The Years of Experience field must be an integer',
			'exp_required.min' => 'The Years of Experience field must be at least 0',
			'seq_value.required' => 'The Sequence field is required',
			'seq_value.integer' => 'The Sequence field must be an integer',
			'seq_value.min' => 'The Sequence field must be at least 1',
		];
	}
}
