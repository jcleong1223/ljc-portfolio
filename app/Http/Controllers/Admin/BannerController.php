<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\CreateFormRequest;
use App\Http\Requests\Admin\Banner\ListFormRequest;
use App\Http\Requests\Admin\Banner\UpdateFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Models\Banner;
use App\Models\ModelableFile;
use App\Queriplex\BannerQueriplex;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
	public function list(ListFormRequest $request)
	{
		$payload = $request->validated();

		$query = BannerQueriplex::make(Banner::query(), $payload);

		$result = $query->paginate($payload['itemsPerPage'] ?? 15);
		$result->load([
			'webImage',
			'mobileImage',
		]);

		return self::successResponse('Success', $result);
	}

	public function create(CreateFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$banner = Banner::create([]);

			$banner->updateSortColumn('seq_value', $payload['seq_value']);
			$banner->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_BANNER_WEB_IMAGE, 2000);
			$banner->syncResizedImageFor('mobileImage', $payload['mobile_image'], ModelableFile::MODULE_PATH_BANNER_MOBILE_IMAGE, 1200);

			return $banner;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$banner = Banner::query()
				->where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$banner->updateSortColumn('seq_value', $payload['seq_value']);
			$banner->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_BANNER_WEB_IMAGE, 2000);
			$banner->syncResizedImageFor('mobileImage', $payload['mobile_image'], ModelableFile::MODULE_PATH_BANNER_MOBILE_IMAGE, 1200);

			return $banner;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();
		$payload = ['id' => $payload['id']];

		$banner = Banner::query()
			->where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $banner->restoreOrDelete(function ($isRestored) use ($banner)
		{
			$banner->restoreOrDeleteSortColumn('seq_value', $isRestored);
		});

		return self::successResponse('Success', $result);
	}
}
