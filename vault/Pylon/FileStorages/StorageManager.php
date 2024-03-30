<?php

namespace Pylon\FileStorages;

use Exception;
use Illuminate\Support\Facades\Storage;

class StorageManager
{
	protected $disk;

	protected $folder_path;

	public function __construct(?String $disk_name)
	{
		if ($disk_name == null)
		{
			$disk_name = config('filesystems.default');
		}
		$this->disk = Storage::disk($disk_name);
	}

	public static function disk(?String $disk_name)
	{
		$static = new static($disk_name);
		return $static;
	}

	public function setFolderPath($folder_path)
	{
		$this->folder_path = $folder_path;
		return $this;
	}

	public function clearFolder()
	{
		if ($this->folder_path == null)
		{
			throw new Exception('folder_path cannot be null', 400);
		}

		$files = $this->disk->files($this->folder_path);
		$this->disk->delete($files);
	}

	public function upload($file, String $file_name)
	{
		$path = $this->disk->put($this->folder_path . '/' . $file_name, $file);
	}

	public function removeFile(String $file_name)
	{
		$this->disk->delete($file_name);
	}
}
