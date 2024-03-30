<?php

namespace Pylon\FileProcessors;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageEditor
{
	protected $imageFile;

	protected $imageObject;

	protected $uuName;

	protected $extension;

	public function __construct($imageFile)
	{
		$this->imageFile = $imageFile;
		$this->extension = $imageFile->getClientOriginalExtension();
		if ($this->extension == '')
		{
			$this->extension = 'jpg';
		}
		$this->uuName = Str::uuid()->toString() . '.' . $this->extension;

		$imageObject = Image::make($imageFile);
		$imageObject->orientate();
		$this->imageObject = $imageObject;
	}

	public static function make($img)
	{
		$static = new static($img);
		return $static;
	}

	public function oriImage()
	{
		$newImageObject = clone $this->imageObject;
		return $newImageObject;
	}

	public function makeResizeImage($maxSize = 800)
	{
		$newImageObject = clone $this->imageObject;

		return $newImageObject->resize($maxSize, $maxSize, function ($constraint)
		{
			$constraint->aspectRatio();
		});
	}

	public function makeThumbnailImage($maxSize = 200)
	{
		return $this->makeResizeImage($maxSize);
	}

	public function getImageInfo()
	{
		$file = $this->imageFile;

		return collect([
			'ori_name' => $file->getClientOriginalName(),
			'uu_name' => $this->uuName,
			'mime_type' => $file->getMimeType(),
			'extension' => $this->extension,
			'size' => $file->getSize(),
		]);
	}
}
