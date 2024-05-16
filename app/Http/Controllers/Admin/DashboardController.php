<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\RoleTag;
use App\Models\Certificate;
use App\Models\PortfolioProject;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
	public function getDashboard()
	{
		$user_count = User::whereHas('roles', function ($q)
		{
			$q->whereIn('name', RoleTag::getAdminOnlyRoles());
		})->count();

		$project_count = PortfolioProject::where('status', 1)->count();

		$certificate_count = Certificate::where('status', 1)->count();

		$tag_count = Tag::where('status', 1)->count();

		$result = [
			'user_count' => $user_count,
			'project_count' => $project_count,
			'certificate_count' => $certificate_count,
			'tag_count' => $tag_count
		];

		return self::successResponse('Success', $result);
	}
}
