<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ModelableFile extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'name',
		'file_type_key',
		'disk',
		'module_path',
		'mime_type',
		'extension',
		'size',
		'priority',
		'folder_type_key',
		'thumbnail',
		'deleted_at',
	];

	protected $hidden = [
		'file_type_key',
		'disk',
		'module_path',
		'mime_type',
		'extension',
		'modelable_id',
		'modelable_type',
		'folder_type_key',
	];

	protected $casts = [];

	protected $appends = [
		'file_url',
		'thumbnail_url',
	];

	// file-type
	public const FILE_TYPE_IMAGE = 1;
	public const FILE_TYPE_VIDEO = 2;
	public const FILE_TYPE_AUDIO = 3;
	public const FILE_TYPE_SPREADSHEET = 4;
	public const FILE_TYPE_PDF = 5;
	public const FILE_TYPE_DOCX = 6;

	// folder-type
	public const FOLDER_TYPE_NONE = 0;
	public const FOLDER_TYPE_MODEL_ID = 1;

	// module-path
	public const MODULE_PATH_USER_AVATAR = 'user-avatars';
	public const MODULE_PATH_BANNER_WEB_IMAGE = 'banner-web-image';
	public const MODULE_PATH_BANNER_MOBILE_IMAGE = 'banner-mobile-image';
	public const MODULE_PATH_PRODUCT_IMAGE = 'product-image';
	public const MODULE_PATH_PRODUCT_CONTENT = 'product-content-image';
	public const MODULE_PATH_PRODUCT_FILE = 'product-file';
	public const MODULE_PATH_CERTIFICATE_WEB_IMAGE = 'certificate-web-image';
	public const MODULE_PATH_CLIENT_WEB_IMAGE = 'client-web-image';
	public const MODULE_PATH_FABRICATION_IMAGE = 'fabrication-image';
	public const MODULE_PATH_FABRICATION_CONTENT = 'fabrication-content-image';
	public const MODULE_PATH_CAPABILITY_IMAGE = 'capability-image';
	public const MODULE_PATH_CAPABILITY_CONTENT = 'capability-content-image';
	public const MODULE_PATH_CAREER_RESUME_FILE = "career-resume-file";
	public const MODULE_PATH_PORTFOLIO_IMAGE = 'portfolio-image';
	public const MODULE_PATH_TAG_WEB_IMAGE = 'tag-web-image';

	// accessor
	public function getPathPrefixAttribute()
	{
		$url = null;
		$disk = Storage::disk($this->disk);

		switch ($this->folder_type_key)
		{
			case self::FOLDER_TYPE_MODEL_ID:
				$url = $this->module_path . '/' . $this->modelable_id . '/';
				break;
			default:
				$url = $this->module_path . '/';
				break;
		}

		return $disk->url($url);
	}

	public function getFileUrlAttribute()
	{
		return $this->path_prefix . $this->name;
	}

	public function getThumbnailUrlAttribute()
	{
		if ($this->thumbnail != null)
		{
			return $this->path_prefix . $this->thumbnail;
		}
		return $this->thumbnail;
	}

	// mutator

	// relationships
	public function modelable()
	{
		return $this->morphTo();
	}

	// extend relationships

	// methods

	// static methods
	public static function defaultImage(string $name = 'default-rectangle.png', string $modulePath = 'default', string $disk = 'images'): array
	{
		return [
			'name' => $name,
			'module_path' => $modulePath,
			'disk' => $disk,
			'file_type_key' => self::FILE_TYPE_IMAGE,
		];
	}
}
