<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;
use Pylon\Models\Traits\HasSortColumn;

class ProductCategory extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasSortColumn;
	use HasSoftDeletesActivity;
	use HasModelKit;

	protected $fillable = [
		'name',
		'seq_value',
	];

	protected $hidden = [];

	protected $casts = [];

	protected $appends = [];

	### Accessors

	### Mutators

	### Relationships
	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_category_mappings', 'product_category_id', 'product_id');
	}

	### Extend relationships

	### Methods

	### Static Methods
}
