<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
			'id' => ['required'],
			'name' => ['required'],
			'email' => ['required', 'unique:users,email,' . $this->id],
			'send_email' => ['nullable'],
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
