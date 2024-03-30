<?php

namespace Pylon\FileStorages;

use App\Models\ModelableFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Pylon\FileProcessors\ImageEditor;

class ModelableFileUploader
{
	public UploadedFile $file;

	public Model $model;

	public string $disk;

	public string $modulePath;

	public string $fileTypeKey;

	public string $name = '';

	public string $thumbnail = '';

	public string $mimeType = '';

	public string $extension = '';

	public int $size = 0;

	public function __construct(UploadedFile $file, Model $model, $disk = null)
	{
		$this->file = $file;
		$this->model = $model;
		$this->disk = $disk ?? config('filesystems.default');
	}

	public function uploadAsFile($modulePath, $fileTypeKey, $clearFolder = true)
	{
		$modelId = $this->model->id;
		$this->modulePath = $modulePath;
		$this->fileTypeKey = $fileTypeKey;

		$file = $this->file;
		$storageManager = $this->setStorageFolder($modulePath, $modelId, $clearFolder);
		$this->extension = $file->extension();

		$fileName = Str::uuid() . '.' . $this->extension;
		$content = fopen($file, 'r');
		$storageManager->upload($content, $fileName);
		fclose($content);
		$this->name = $fileName;

		$this->mimeType = $file->getMimeType();
		$this->size = $file->getSize();

		return $this;
	}

	public function uploadAsResizedImage($modulePath, $maxSize, $clearFolder = true)
	{
		$modelId = $this->model->id;
		$this->modulePath = $modulePath;
		$this->fileTypeKey = ModelableFile::FILE_TYPE_IMAGE;

		$imageEditor = ImageEditor::make($this->file);
		$imageInfo = $imageEditor->getImageInfo();
		$storageManager = $this->setStorageFolder($modulePath, $modelId, $clearFolder);

		$fileName = $imageInfo->get('uu_name');
		$fitImage = $imageEditor->makeResizeImage($maxSize)->encode();
		$storageManager->upload($fitImage, $fileName);
		$this->name = $fileName;

		$thumbnailName = 'thumbnail_' . $fileName;
		$thumbnail = $imageEditor->makeThumbnailImage()->encode();
		$storageManager->upload($thumbnail, $thumbnailName);
		$this->thumbnail = $thumbnailName;

		$this->mimeType = $imageInfo->get('mime_type');
		$this->extension = $imageInfo->get('extension');
		$this->size = $imageInfo->get('size');

		return $this;
	}

	public function toPayload(): array
	{
		return [
			'name' => $this->name,
			'disk' => $this->disk,
			'module_path' => $this->modulePath,
			'file_type_key' => $this->fileTypeKey,
			'mime_type' => $this->mimeType,
			'extension' => $this->extension,
			'size' => $this->size,
			'thumbnail' => $this->thumbnail,
		];
	}

	private function setStorageFolder(string $modulePath, int $modelId, bool $clearFolder = false): StorageManager
	{
		$storageManager = StorageManager::disk($this->disk);
		$storageManager->setFolderPath($modulePath . '/' . $modelId);
		if ($clearFolder)
		{
			$storageManager->clearFolder();
		}

		return $storageManager;
	}
}
