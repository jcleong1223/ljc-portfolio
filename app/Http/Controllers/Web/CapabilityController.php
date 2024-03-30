<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParamIdFormRequest;
use App\Models\Service;

class CapabilityController extends Controller
{
	public function home()
	{
		$capabilities = Service::where('status', 1)->orderBy('seq_value', 'ASC')
			->with([
				'image',
				'mediaContents.content',
			])
			->get();

		$result = [
			'capabilities' => $capabilities,
		];

		return self::successResponse('Success', $result);
	}

	public function info(ParamIdFormRequest $request)
	{
		$payload = $request->validated();
		$capability = Service::with([
			'image',
			'mediaContents.content',
		])->find($payload);

		$result = [
			'capability' => $capability->first(),
		];

		return self::successResponse('Success', $result);
	}
}
