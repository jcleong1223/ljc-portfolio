<?php

namespace App\Http\Services;

use App\Models\ModelableFile;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductService
{
	public static function syncGalleries(Product $product, array $galleriesPayload)
	{
		$collection = collect();
		collect($galleriesPayload)->each(function ($item, $key) use ($product, $collection)
		{
			if ($item instanceof UploadedFile)
			{
				$mediaContent = $product->mediaContents()->create([
					'seq_value' => $key+1,
				]);

				$mediaContent->syncResizedImageFor('content', $item, ModelableFile::MODULE_PATH_PRODUCT_CONTENT, 1000);
				$collection->push($mediaContent);
			}
			else
			{
				$mediaContent = $product->mediaContents()->where('id', $item)->first();
				if ($mediaContent)
				{
					$mediaContent->update([
						'seq_value' => $key+1,
					]);
					$collection->push($mediaContent);
				}
			}
		});

		$toKeepIds= $collection->pluck('id');
		$product->mediaContents()->whereNotIn('id', $toKeepIds)->delete();

		return $collection;
	}

	public static function syncSpecifications(Product $product, array $specificationsPayload)
	{
		$collection = collect();
		collect($specificationsPayload)->each(function ($item, $key) use ($product, $collection)
		{
			if (isset($item['id']))
			{
				$specification = $product->specifications()->where('id', $item)->first();
				if ($specification)
				{
					$specification->update([
						'title' => $item['title'],
						'value' => $item['value'],
					]);
					$collection->push($specification);
				}
			}
			else
			{
				$specification = $product->specifications()->create([
					'title' => $item['title'],
					'value' => $item['value'],
				]);
				$collection->push($specification);
			}
		});

		$toKeepIds= $collection->pluck('id');
		$product->specifications()->whereNotIn('id', $toKeepIds)->delete();

		return $collection;
	}
}
