<?php

namespace Pylon\Models\Traits;

use Closure;
use Illuminate\Support\Facades\DB;

trait HasSortColumn
{
	/**
	 * Re-order sort-column based on old-seq and new-seq.
	 *
	 * @param mixed   $column              Column Name
	 * @param int     $to                  To
	 * @param Closure $customQueryCallback Custom Query Callback
	 *
	 * - Use to override default query-builder (**see code for more**)
	 * - Return a query build that used to sync others record's sequence.
	 *
	 * - Example:
	 * ```
	 * function($q){
	 * 	return $q->where('someCondition', ...);
	 * }
	 * ```
	 */
	public function updateSortColumn($column, int $to, ?Closure $customQueryCallback = null)
	{
		$from = $this->{$column} ?? 0;
		$this->update([
			$column => $to,
		]);

		$queryBuilder = $this->newQuery();
		if ($customQueryCallback)
		{
			$queryBuilder = $customQueryCallback($queryBuilder);
		}
		else
		{
			if (method_exists($this, 'bootSoftDeletes'))
			{
				$queryBuilder->withTrashed();
			}
		}

		if ($from == 0)
		{
			return $queryBuilder->where($column, '>=', $to)
				->where('id', '!=', $this->id)
				->update([
					$column => DB::raw("`$column` + 1"),
					'updated_at' => DB::raw('updated_at'),
				]);
		}
		elseif ($from > $to)
		{
			return $queryBuilder->where($column, '>=', $to)
				->where($column, '<=', $from)
				->where('id', '!=', $this->id)
				->update([
					$column => DB::raw("`$column` + 1"),
					'updated_at' => DB::raw('updated_at'),
				]);
		}
		elseif ($from < $to)
		{
			return $queryBuilder->where($column, '>=', $from)
				->where($column, '<=', $to)
				->where('id', '!=', $this->id)
				->update([
					$column => DB::raw("`$column` - 1"),
					'updated_at' => DB::raw('updated_at'),
				]);
		}
	}

	public function restoreOrDeleteSortColumn($column, $isRestore = false)
	{
		$queryBuilder = $this->newQuery();
		$queryBuilder->where($column, '>=', $this->{$column})
			->where('id', '!=', $this->id);

		if ($isRestore)
		{
			return $queryBuilder->update([
				$column => DB::raw("`$column` + 1"),
				'updated_at' => DB::raw('updated_at'),
			]);
		}
		else
		{
			return $queryBuilder->update([
				$column => DB::raw("`$column` - 1"),
				'updated_at' => DB::raw('updated_at'),
			]);
		}
	}
}
