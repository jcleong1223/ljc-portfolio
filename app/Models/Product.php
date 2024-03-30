<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelableFile;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;

class Product extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasModelKit;
	use HasModelableFile;

	protected $fillable = [
		'title',
		'price',
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
			->where('module_path', ModelableFile::MODULE_PATH_PRODUCT_IMAGE)
			->withDefault(ModelableFile::defaultImage());
	}

	public function file()
	{
		return $this->morphOne(ModelableFile::class, 'modelable')
			->where('module_path', ModelableFile::MODULE_PATH_PRODUCT_FILE);
	}

	public function detail()
	{
		return $this->hasOne(ProductDetail::class);
	}

	public function mediaContents()
	{
		return $this->hasMany(ProductContent::class)->orderBy('seq_value', 'ASC');
	}

	public function categories()
	{
		return $this->belongsToMany(ProductCategory::class, 'product_category_mappings', 'product_id', 'product_category_id');
	}

	public function specifications()
	{
		return $this->hasMany(ProductSpecification::class);
	}

	### Extend relationships

	### Methods

	### Static Methods
}
