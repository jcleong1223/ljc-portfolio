<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Pylon\FormRequests\Traits\MergeRequestParams;

class IdOnlyFormRequest extends FormRequest
{
	use MergeRequestParams;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id' => 'required',
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
