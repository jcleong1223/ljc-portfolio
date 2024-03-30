<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Library\RoleTag;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
	public function index(Request $request)
	{
		$payload = $request->validate([
			'search' => ['nullable'],
		]);

		$displaying_groups = [
			// GeneralSetting::GROUP_APP_VERSION,
			// GeneralSetting::GROUP_APP_ENDPOINT,
			GeneralSetting::GROUP_APP_SETTING,
		];

		$query = GeneralSetting::whereIn('group', $displaying_groups);

		if (isset($payload['search']))
		{
			$query->keywordSearch('key', $payload['search']);
		}

		if (!auth()->user()->hasRole(RoleTag::NEXUS_SUPER_ADMIN))
		{
			$query->where('access_level', '<', '1');
		}

		$collection = $query->get();

		$result = $collection->groupBy('group');

		return self::successResponse('Success', $result);
	}

	public function update(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
			'value' => ['required', 'nullable'],
			'description' => ['nullable'],
		]);

		$generalSetting = GeneralSetting::where('id', $payload['id'])->firstOrThrowError();
		if (!auth()->user()->hasRole(RoleTag::NEXUS_SUPER_ADMIN))
		{
			if (!$generalSetting->access_level < 1)
			{
				throw BadRequestException::invalidPermissionError();
			}
		}

		if (!$generalSetting->is_editable)
		{
			throw new BadRequestException('Selected field is not editable');
		}

		if ($generalSetting->data_type == GeneralSetting::DATA_TYPE_JSON)
		{
			$payload['value'] = json_decode($payload['value']);
		}

		$generalSetting->update([
			'content' => $payload['value'] ?: '',
			'description' => $payload['description'],
		]);

		return self::successResponse('Success', $generalSetting);
	}
}
