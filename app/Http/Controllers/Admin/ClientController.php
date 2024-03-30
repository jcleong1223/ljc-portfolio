<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\CreateClientFormRequest;
use App\Http\Requests\Admin\Client\ListFormRequest as ClientListFormRequest;
use App\Http\Requests\Admin\Client\UpdateClientFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Models\Client;
use App\Models\ModelableFile;
use App\Queriplex\ClientQueriplex;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
	public function list(ClientListFormRequest $request)
	{
		$payload = $request->validated();

		$result = ClientQueriplex::make(Client::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'webImage',
		]);
		return self::successResponse('Success', $result);
	}

	public function create(CreateClientFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$client = Client::create([
				'name' => $payload['name'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$client->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_CLIENT_WEB_IMAGE, 2000);

			return $client;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateClientFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$client = Client::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$client->update([
				'name' => $payload['name'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$client->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_CLIENT_WEB_IMAGE, 2000);

			return $client;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Client::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
