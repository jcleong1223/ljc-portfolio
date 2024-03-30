<?php

namespace App\Http\Middleware;

use App\Exceptions\BadRequestException;
use App\Library\ResponseCode;
use App\Models\GeneralSetting;
use Closure;

class CheckAppVersion
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user_app_version = $request->headers->get('app-version');
		$user_os_type = $request->headers->get('os-type');

		$app_version = GeneralSetting::where('group', GeneralSetting::GROUP_APP_VERSION)
			->where('key', $user_os_type)
			->firstOr(function ()
			{
				throw new BadRequestException('Bad App OS');
			});

		$user_app_version = $this->getMinorVersion($user_app_version);
		$app_version = $this->getMinorVersion($app_version->value);

		// <major.minor.patch> eg: 1.0.1
		if (version_compare($user_app_version, $app_version, '<'))
		{
			throw (new BadRequestException('New Version Available', 409))
				->withErrorKey(ResponseCode::FORCE_UPDATE, 'FORCE_UPDATE');
		}

		return $next($request);
	}

	public function getMinorVersion($version_str)
	{
		$arr = explode('.', $version_str);
		$arr = array_slice($arr, 0, 2);
		$minorVersionStr = join('.', $arr);

		return $minorVersionStr;
	}
}
