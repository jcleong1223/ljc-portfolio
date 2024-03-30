<?php

namespace App\Http\Services;

use App\Models\Fabrication;
use App\Models\ModelableFile;
use Illuminate\Http\UploadedFile;

class FabricationService
{
	public static function syncGalleries(Fabrication $fabrication, array $galleriesPayload)
	{
		$collection = collect();
		collect($galleriesPayload)->each(function ($item, $key) use ($fabrication, $collection)
		{
			if ($item instanceof UploadedFile)
			{
				$mediaContent = $fabrication->mediaContents()->create([
					'seq_value' => $key+1,
				]);

				$mediaContent->syncResizedImageFor('content', $item, ModelableFile::MODULE_PATH_FABRICATION_CONTENT, 1000);
				$collection->push($mediaContent);
			}
			else
			{
				$mediaContent = $fabrication->mediaContents()->where('id', $item)->first();
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
		$fabrication->mediaContents()->whereNotIn('id', $toKeepIds)->delete();

		return $collection;
	}
}
