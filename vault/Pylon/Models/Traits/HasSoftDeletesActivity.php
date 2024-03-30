<?php

namespace Pylon\Models\Traits;

use Closure;

trait HasSoftDeletesActivity
{
	public function scopeWhereActivity($query, $value = 1)
	{
		switch ($value)
		{
			case 0: // 0+0
				$query->onlyTrashed();
				break;
			case 2: // 1+1
				$query->withTrashed();
				break;
			default: // 0+1
				// by default, only show is_deleted = null
				break;
		}
	}

	/**
	 * Restore or soft-delete the model and execute a callback function.
	 *
	 * @param Closure|null $callback The optional callback function to execute with the restore status.
	 *
	 * @return bool|int
	 */
	public function restoreOrDelete(Closure $callback = null)
	{
		$isRestore = false;
		$result = null;

		if ($this->trashed())
		{
			$result = $this->restore();
			$isRestore = true;
		}
		else
		{
			$result = $this->delete();
		}

		if ($callback && is_callable($callback))
		{
			$callback($isRestore);
		}

		return $result;
	}
}
