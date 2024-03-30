<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Certificate\CreateCertificateFormRequest;
use App\Http\Requests\Admin\Certificate\ListFormRequest as CertificateListFormRequest;
use App\Http\Requests\Admin\Certificate\UpdateCertificateFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Models\Certificate;
use App\Models\ModelableFile;
use App\Queriplex\CertificateQueriplex;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
	public function list(CertificateListFormRequest $request)
	{
		$payload = $request->validated();

		$result = CertificateQueriplex::make(Certificate::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'webImage',
		]);
		return self::successResponse('Success', $result);
	}

	public function create(CreateCertificateFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$certificate = Certificate::create([
				'title' => $payload['title'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$certificate->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_CERTIFICATE_WEB_IMAGE, 2000);

			return $certificate;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateCertificateFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$certificate = Certificate::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$certificate->update([
				'title' => $payload['title'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$certificate->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_CERTIFICATE_WEB_IMAGE, 2000);

			return $certificate;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Certificate::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
