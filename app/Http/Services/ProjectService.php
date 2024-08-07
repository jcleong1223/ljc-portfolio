<?php

namespace App\Http\Services;

use App\Models\ModelableFile;
use App\Models\PortfolioProject;
use Illuminate\Http\UploadedFile;

class ProjectService
{
	public static function syncGalleries(PortfolioProject $service, array $galleriesPayload)
	{
		$collection = collect();
		collect($galleriesPayload)->each(function ($item, $key) use ($service, $collection)
		{
			if ($item instanceof UploadedFile)
			{
				$mediaContent = $service->mediaContents()->create([
					'seq_value' => $key+1,
				]);

				$mediaContent->syncResizedImageFor('content', $item, ModelableFile::MODULE_PATH_PORTFOLIO_CONTENT_IMAGE, 2000);
				$collection->push($mediaContent);
			}
			else
			{
				$mediaContent = $service->mediaContents()->where('id', $item)->first();
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
		$service->mediaContents()->whereNotIn('id', $toKeepIds)->delete();

		return $collection;
	}
}
