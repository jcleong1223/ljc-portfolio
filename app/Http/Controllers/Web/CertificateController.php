<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Certificate;

class CertificateController extends Controller
{
	public function home()
	{
		$certificates = Certificate::where('status', 1)->orderBy('seq_value', 'ASC')
		->with([
			'webImage',
		])
		->get();

		$result = [
			'certificates' => $certificates,
		];

		return self::successResponse('Success', $result);
	}
}
