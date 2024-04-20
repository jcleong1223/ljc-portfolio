<?php

namespace App\Queriplex;

use Kyrax324\Queriplex\Queriplex;

class ServiceQueriplex extends Queriplex
{
	public function filterRules()
	{
		return [
			'id' => 'id',
			'title' => 'title',
			'search' => (fn ($query, $value) => $this->searchQuery($query, $value)),
			'activity' => function ($query, $value)
			{
				$query->whereActivity($value);
			},
		];
	}

	public function sortRules()
	{
		$order_mode = $this->getInput('sortDesc') ? 'DESC' : 'ASC';

		return [
			'id' => fn ($query) => $query->orderBy('id', $order_mode),
			'title' => fn ($query) => $query->orderBy('title', $order_mode),
			'created_time' => fn ($query) => $query->orderBy('created_at', $order_mode),
			'seq_value' => fn ($query) => $query->orderBy('seq_value', $order_mode),
			'created_at' => fn ($query) => $query->orderBy('created_at', $order_mode),
		];
	}

	private function searchQuery($query, $value)
	{
		$search_by = $this->getInput('searchBy');

		$common_searchable = [
			'title',
			'id',
		];

		if (in_array($search_by, $common_searchable))
		{
			$query->keywordSearch($search_by, $value);
		}

		return null;
	}
}