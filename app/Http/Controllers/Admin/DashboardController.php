<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\RoleTag;
use App\Models\User;

class DashboardController extends Controller
{
	public function getDashboard()
	{
		$user_count = User::whereHas('roles', function ($q)
		{
			$q->whereIn('name', RoleTag::getAdminOnlyRoles());
		})->count();

		$result = [
			'user_count' => $user_count,
		];

		return self::successResponse('Success', $result);
	}
}
