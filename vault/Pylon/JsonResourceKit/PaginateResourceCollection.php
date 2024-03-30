<?php

namespace Pylon\JsonResourceKit;

use Illuminate\Support\Arr;

class PaginateResourceCollection extends BaseAnonymousResourceCollection
{
	public function toArray($request)
	{
		$paginatorArr = $this->resource->toArray();

		$data = [
			'current_page' => $paginatorArr['current_page'],
			'data' => $paginatorArr['data'],
			'to' => $paginatorArr['to'],
			'from' => $paginatorArr['from'],
			// 'paginator' => $this->meta($paginatorArr),
		];

		if (isset($paginatorArr['total']))
		{
			$data['total'] =  $paginatorArr['total'];
		}

		return $data;
	}

	/**
	 * Gather the meta data for the response.
	 *
	 * @param array $paginated
	 *
	 * @return array
	 */
	protected function meta($paginated)
	{
		return Arr::only($paginated, [
			'current_page',
			'from',
			'last_page',
			'per_page',
			'to',
			'total',
		]);
	}
}
