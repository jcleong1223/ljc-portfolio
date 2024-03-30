<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategory\CreateFormRequest as CreateProductCategoryFormRequest;
use App\Http\Requests\Admin\ProductCategory\ListFormRequest as ListProductCategoryFormRequest;
use App\Http\Requests\Admin\ProductCategory\UpdateFormRequest as UpdateProductCategoryFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Models\ProductCategory;
use App\Queriplex\ProductCategoryQueriplex;

class ProductCategoryController extends Controller
{
	public function list(ListProductCategoryFormRequest $request)
	{
		$payload = $request->validated();

		$result = ProductCategoryQueriplex::make(ProductCategory::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		return self::successResponse('Success', $result);
	}

	public function info($id)
	{
		$result = ProductCategory::where('id', $id)
					->withTrashed()
					->first();

		return self::successResponse('Success', $result);
	}

	public function create(CreateProductCategoryFormRequest $request)
	{
		$payload = $request->validated();

		$result = ProductCategory::create([
			'name' => $payload['name'],
		]);

		$result->updateSortColumn('seq_value', $payload['seq_value']);

		return self::successResponse('Success', $result);
	}

	public function update(UpdateProductCategoryFormRequest $request)
	{
		$payload = $request->validated();

		$result = ProductCategory::where('id', $payload['id'])
					->withTrashed()
					->firstOrThrowError();

		$result->update([
			'name' => $payload['name'],
		]);

		$result->updateSortColumn('seq_value', $payload['seq_value']);
		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = ProductCategory::where('id', $payload['id'])
					->withTrashed()
					->firstOrThrowError();

		$result = $object->restoreOrDelete(function ($isRestored) use ($object)
		{
			$object->restoreOrDeleteSortColumn('seq_value', $isRestored);
		});

		return self::successResponse('Success', $result);
	}
}
