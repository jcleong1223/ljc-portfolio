<?php

namespace Pylon\QueueJob;

class QueueJobKit
{
	/**
	 * JobDispatch
	 *
	 * @param mixed $job
	 *
	 * @return int job's id
	 */
	public static function jobDispatcher($job): int
	{
		return app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
	}
}
