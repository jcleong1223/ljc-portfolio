<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Fabrication\CreateFabricationFormRequest;
use App\Http\Requests\Admin\Fabrication\ListFormRequest as FabricationListFormRequest;
use App\Http\Requests\Admin\Fabrication\UpdateFabricationFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Services\FabricationService;
use App\Models\Fabrication;
use App\Models\ModelableFile;
use App\Queriplex\FabricationQueriplex;
use Illuminate\Support\Facades\DB;

class FabricationController extends Controller
{
	public function list(FabricationListFormRequest $request)
	{
		$payload = $request->validated();

		$result = FabricationQueriplex::make(Fabrication::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'image',
			'mediaContents.content',
		]);
		return self::successResponse('Success', $result);
	}

	public function create(CreateFabricationFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$fabrication = Fabrication::create([
				'title' => $payload['title'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$fabrication->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_FABRICATION_IMAGE, 2000);

			FabricationService::syncGalleries($fabrication, $payload['media_contents'] ?? []);
			return $fabrication;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateFabricationFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$fabrication = Fabrication::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$fabrication->update([
				'title' => $payload['title'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$fabrication->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_FABRICATION_IMAGE, 2000);

			FabricationService::syncGalleries($fabrication, $payload['media_contents'] ?? []);
			return $fabrication;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Fabrication::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
