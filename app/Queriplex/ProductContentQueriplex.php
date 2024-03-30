<?php

namespace App\Queriplex;

use Kyrax324\Queriplex\Queriplex;

class ProductContentQueriplex extends Queriplex
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
			'product_id' => 'product_id',
			'activity' => function ($query, $value)
			{
				$query->whereActivity($value);
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
			'seq_value' => fn ($query) => $query->orderBy('seq_value', $order_mode),
		];
	}

	private function searchQuery($query, $value)
	{
		if ($value == null)
		{
			return null;
		}

		$search_by = $this->getInput('searchBy');

		$common_searchable = [
			'id',
			'title',
		];
		if (in_array($search_by, $common_searchable))
		{
			$query->keywordSearch($search_by, $value);
		}
		else
		{
			switch ($search_by)
			{
				default:
					# code...
					break;
			}
		}

		return null;
	}
}
