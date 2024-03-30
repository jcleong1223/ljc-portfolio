<?php

namespace App\Http\Requests\Admin\Banner;

use App\Rules\FileOrElse;
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
			'seq_value' => ['required', 'min:1'],
			'web_image' => ['required', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
			'mobile_image' => ['required', new FileOrElse(['max:10240', 'mimes:jpeg,jpg,png,webp'], [])],
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
