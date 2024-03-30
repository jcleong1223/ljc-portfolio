<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelableFile;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;

class Service extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasModelKit;
	use HasModelableFile;

	protected $fillable = [
		'title',
		'short_description',
		'description',
		'status',
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
		return $this->morphOne(ModelableFile::class, 'modelable')
			->where('module_path', ModelableFile::MODULE_PATH_CAPABILITY_IMAGE)
			->withDefault(ModelableFile::defaultImage());
	}

	public function mediaContents()
	{
		return $this->hasMany(ServiceContent::class)->orderBy('seq_value', 'ASC');
	}

	### Extend relationships

	### Methods

	### Static Methods
}
