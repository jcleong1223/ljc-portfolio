<?php

namespace Pylon\FormRequests\Traits;

trait MergeRequestParams
{
	/**
	 * @override | prepareForValidation
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge($this->route()->parameters());
	}
}
