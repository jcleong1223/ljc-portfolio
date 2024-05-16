<?php

namespace App\Http\Services;

use App\Models\ModelableFile;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Http\UploadedFile;

class CapabilityService
{
	public static function syncGalleries(PortfolioProject $project, array $galleriesPayload)
	{
		$collection = collect();
		collect($galleriesPayload)->each(function ($item, $key) use ($project, $collection)
		{
			if ($item instanceof UploadedFile)
			{
				$mediaContent = $project->mediaContents()->create([
					'seq_value' => $key+1,
				]);

				$mediaContent->syncResizedImageFor('content', $item, ModelableFile::MODULE_PATH_CAPABILITY_CONTENT, 1000);
				$collection->push($mediaContent);
			}
			else
			{
				$mediaContent = $project->mediaContents()->where('id', $item)->first();
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
		$project->mediaContents()->whereNotIn('id', $toKeepIds)->delete();

		return $collection;
	}
}
