<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelableFile;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;

class ProductContent extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasModelKit;
	use HasModelableFile;

	protected $fillable = [
		'seq_value',
		'product_id',
	];

	protected $hidden = [];

	protected $casts = [];

	protected $appends = [];
	public const TYPE_IMAGE = 1;

	### Accessors

	### Mutators

	### Relationships
	public function content()
	{
		return $this->morphOne(ModelableFile::class, 'modelable')
			->withDefault(ModelableFile::defaultImage());
	}

	### Extend relationships

	### Methods

	### Static Methods
}
