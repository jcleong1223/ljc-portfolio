<?php

namespace Pylon\Models\Traits;

use Illuminate\Http\UploadedFile;
use Pylon\FileStorages\ModelableFileUploader;

trait HasModelableFile
{
	public function syncResizedImageFor($relation, $value, $modulePath, $maxSize, $clearFolder = true)
	{
		$result = null;
		if ($value instanceof UploadedFile)
		{
			$uploader = new ModelableFileUploader($value, $this);
			$uploader->uploadAsResizedImage($modulePath, $maxSize, $clearFolder);
			$result = $this->{$relation}()->updateOrCreate([], $uploader->toPayload());
		}
		elseif ($value == null)
		{
			$result = $this->{$relation}->delete();
		}

		return $result;
	}

	public function syncFileFor($relation, $value, $modulePath, $fileTypeKey, $clearFolder = true)
	{
		$result = null;
		if ($value instanceof UploadedFile)
		{
			$uploader = new ModelableFileUploader($value, $this);
			$uploader->uploadAsFile($modulePath, $fileTypeKey, $clearFolder);
			$result = $this->{$relation}()->updateOrCreate([], $uploader->toPayload());
		}
		elseif ($value == null)
		{
			$result = $this->{$relation}->delete();
		}

		return $result;
	}
}
