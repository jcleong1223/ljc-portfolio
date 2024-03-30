<?php

namespace App\Queriplex;

use Kyrax324\Queriplex\Queriplex;

class UserQueriplex extends Queriplex
{
	/**
	 * Get the filtering rules that apply to the model builder.
	 *
	 * @return array
	 */
	public function filterRules()
	{
		return [
			'id' => 'id',
			'activity' => function ($query, $value)
			{
				$query->whereActivity($value);
			},
			'roles' => function ($query, array $values)
			{
				$query->whereHas('roles', function ($q) use ($values)
				{
					$q->whereIn('name', $values);
				});
			},
			'search' => (fn ($query, $value) => $this->searchQuery($query, $value)),
		];
	}

	/**
	 * Get the sorting rules that apply to the model builder.
	 *
	 * @return array
	 */
	public function sortRules()
	{
		$order_mode = $this->getInput('sortDesc') ? 'DESC' : 'ASC';

		return [
			'id' => fn ($query) => $query->orderBy('id', $order_mode),
			'created_time' => fn ($query) => $query->orderBy('created_at', $order_mode),
		];
	}

	private function searchQuery($query, $value)
	{
		$search_by = $this->getInput('searchBy');

		$common_searchable = [
			'id',
			'name',
			'email',
		];

		if (in_array($search_by, $common_searchable))
		{
			$query->keywordSearch($search_by, $value);
		}

		return null;
	}
}
