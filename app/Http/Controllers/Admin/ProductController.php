<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductFormRequest;
use App\Http\Requests\Admin\Product\ListFormRequest as ProductListFormRequest;
use App\Http\Requests\Admin\Product\UpdateProductFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
// use App\Http\Requests\Admin\Product\SyncImageFormRequest;
use App\Http\Requests\ParamIdFormRequest;
use App\Http\Services\ProductService;
use App\Models\ModelableFile;
use App\Models\Product;
use App\Queriplex\ProductQueriplex;
use Illuminate\Support\Facades\DB;

// use App\Http\Resources\Admin\ProductResource;

class ProductController extends Controller
{
	public function list(ProductListFormRequest $request)
	{
		$payload = $request->validated();

		$result = ProductQueriplex::make(Product::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'detail',
			'image',
			'mediaContents.content',
			'categories',
			'file',
			'specifications',
		]);

		// $result = ProductResource::paginateCollection($result);

		return self::successResponse('Success', $result);
	}

	public function info(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$result = ProductQueriplex::make(Product::query(), $payload)
				->withTrashed()
				->firstOrThrowError();

		$result->load([
			'detail',
			'image',
			'mediaContents.content',
			'categories',
			'file',
			'specifications',
		]);

		$result->description = $result->detail->description;
		unset($result->detail);

		return self::successResponse('Success', $result);
	}

	public function create(CreateProductFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$product = Product::create([
				'title' => $payload['title'],
				'price' => $payload['price'],
			]);

			$product->detail()->create([
				'description' => $payload['description'],
			]);

			$product->categories()->syncWithoutDetaching($payload['product_category_ids']);

			$product->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_PRODUCT_IMAGE, 600);

			$product->syncFileFor('file', $payload['file'], ModelableFile::MODULE_PATH_PRODUCT_FILE, ModelableFile::FILE_TYPE_PDF);

			ProductService::syncGalleries($product, $payload['media_contents'] ?? []);

			ProductService::syncSpecifications($product, $payload['specifications'] ?? []);

			return $product;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateProductFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$product = Product::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$product->update([
				'title' => $payload['title'],
				'price' => $payload['price'],
			]);

			$product->detail()->updateOrCreate([], [
				'description' => $payload['description'],
			]);

			$product->categories()->syncWithoutDetaching($payload['product_category_ids']);

			$product->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_PRODUCT_IMAGE, 600);

			$product->syncFileFor('file', $payload['file'], ModelableFile::MODULE_PATH_PRODUCT_FILE, ModelableFile::FILE_TYPE_PDF);

			ProductService::syncGalleries($product, $payload['media_contents'] ?? []);

			ProductService::syncSpecifications($product, $payload['specifications'] ?? []);

			return $product;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Product::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
