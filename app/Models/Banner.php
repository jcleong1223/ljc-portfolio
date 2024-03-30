<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelableFile;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;
use Pylon\Models\Traits\HasSortColumn;

class Banner extends Model
{
	use HasFactory;
	use HasModelableFile;
	use HasModelKit;
	use HasSortColumn;
	use HasSoftDeletesActivity;
	use SoftDeletes;

	protected $fillable = [
		'seq_value',
	];

	protected $hidden = [];

	protected $casts = [];

	protected $appends = [];

	### Accessors

	### Mutators

	### Relationships
	public function image()
	{
		return $this->morphOne(ModelableFile::class, 'modelable')->withDefault(ModelableFile::defaultImage());
	}

	### Extend relationships
	public function webImage(): MorphOne
	{
		return $this->image()->where('module_path', ModelableFile::MODULE_PATH_BANNER_WEB_IMAGE);
	}

	public function mobileImage()
	{
		return $this->image()->where('module_path', ModelableFile::MODULE_PATH_BANNER_MOBILE_IMAGE);
	}

	### Methods

	### Static Methods
}
