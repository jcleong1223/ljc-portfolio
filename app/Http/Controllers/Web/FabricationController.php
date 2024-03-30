<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Fabrication;

class FabricationController extends Controller
{
	public function home()
	{
		$fabrications = Fabrication::where('status', 1)->orderBy('seq_value', 'ASC')
		->with([
			'image',
			'mediaContents.content',
		])
		->get();

		$page = ceil(count($fabrications) / 4);

		$result = [
			'fabrications' => $fabrications->take(4),
			'page' => $page,
			'totalResult' => count($fabrications)
		];

		return self::successResponse('Success', $result);
	}

	public function getPaginateData($currentPage)
	{
		$skip = ($currentPage - 1) * 4 ?? 4;

		$fabrications = Fabrication::where('status', 1)->orderBy('seq_value', 'ASC')
		->with([
			'image',
			'mediaContents.content',
		])
		->skip($skip)
		->take(4)
		->get();

		$result = [
			'fabrications' => $fabrications,
		];

		return self::successResponse('Success', $result);
	}
}
