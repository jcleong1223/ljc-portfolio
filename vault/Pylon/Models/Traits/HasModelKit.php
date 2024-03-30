<?php

namespace Pylon\Models\Traits;

use Pylon\Exceptions\BadRequestException;

trait HasModelKit
{
	/**
	 * scope for firstOrThrowError()
	 * -> similar like firstOrFail() but json response.
	 *
	 * @param mixed  $query
	 * @param string $message
	 * @param int    $status
	 *
	 * @return void
	 */
	public function scopeFirstOrThrowError($query, String $message = 'The selected data is invalid', int $status = 400)
	{
		return $query->firstOr(function () use ($message, $status)
		{
			throw new BadRequestException($message, $status);
		});
	}

	/**
	 * Scope a query to search related records. ( unordered string )
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string                                $column
	 * @param string                                $value
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeKeywordSearch($query, $column, $value)
	{
		$keywords = explode(' ', $value);

		return $query->where(function ($q) use ($column, $keywords)
		{
			foreach ($keywords as $keyword)
			{
				$q->where($column, 'like', '%' . $keyword . '%');
			}
		});
	}

	/**
	 * Scope a query to search related records with OR statement. ( unordered string )
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string                                $column
	 * @param string                                $value
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrKeywordSearch($query, $column, $value)
	{
		$keywords = explode(' ', $value);

		return $query->orWhere(function ($q) use ($column, $keywords)
		{
			foreach ($keywords as $keyword)
			{
				$q->where($column, 'like', '%' . $keyword . '%');
			}
		});
	}
}
