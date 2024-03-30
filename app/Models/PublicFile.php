<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PublicFile extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'file_type_key',
		'module_path',
		'mime_type',
		'extension',
		'size',
	];

	protected $hidden = [
		'file_type_key',
		'module_path',
		'mime_type',
		'extension',
	];

	protected $casts = [];

	protected $appends = [
		'file_url',
	];

	// disk
	public const DISK_NAME = 'public-assets';

	// file-type
	public const FILE_TYPE_IMAGE = 1;
	public const FILE_TYPE_VIDEO = 2;
	public const FILE_TYPE_AUDIO = 3;
	public const FILE_TYPE_SPREADSHEET = 4;

	// module paths
	public const MODULE_PATH_CKEDITOR = 'ckeditor';

	// accessor
	public function getPathPrefixAttribute()
	{
		$url = null;
		$disk = Storage::disk(self::DISK_NAME);
		$url = $this->module_path . '/';

		return $disk->url($url);
	}

	public function getFileUrlAttribute()
	{
		return $this->path_prefix . $this->name;
	}

	// mutator

	// relationships

	// extend relationships

	// methods
	public function toCkeditorResult()
	{
		return [
			'default' => $this->file_url,
		];
	}

	// static methods
}
