<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\CreateServiceFormRequest;
use App\Http\Requests\Admin\Service\ListFormRequest as ServiceListFormRequest;
use App\Http\Requests\Admin\Service\UpdateServiceFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Requests\ParamIdFormRequest;
use App\Http\Services\CapabilityService;
use App\Models\ModelableFile;
use App\Models\Service;
use App\Queriplex\ServiceQueriplex;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
	public function list(ServiceListFormRequest $request)
	{
		$payload = $request->validated();

		$result = ServiceQueriplex::make(Service::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'image',
			'mediaContents',
		]);

		return self::successResponse('Success', $result);
	}

	public function info(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$result = ServiceQueriplex::make(Service::query(), $payload)
				->withTrashed()
				->firstOrThrowError();

		$result->load([
			'image',
			'mediaContents.content',
		]);

		return self::successResponse('Success', $result);
	}

	public function create(CreateServiceFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$service = Service::create([
				'title' => $payload['title'],
				'short_description' => $payload['short_description'],
				'description' => $payload['description'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
			]);
			$service->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_CAPABILITY_IMAGE, 2000);

			CapabilityService::syncGalleries($service, $payload['media_contents'] ?? []);

			return $service;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateServiceFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$service = Service::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$service->update([
				'title' => $payload['title'],
				'short_description' => $payload['short_description'],
				'description' => $payload['description'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
			]);

			$service->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_CAPABILITY_IMAGE, 2000);

			CapabilityService::syncGalleries($service, $payload['media_contents'] ?? []);
			return $service;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Service::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
