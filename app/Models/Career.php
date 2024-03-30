<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;
use Pylon\Models\Traits\HasModelableFile;

class Career extends Model
{
	use HasFactory;
	use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasModelKit;

	protected $fillable = [
		'title',
		'location',
		'salary_range',
		'exp_required',
		'type',
		'status',
		'seq_value',
		'description',
		'career_level',
		'specializations',
		'qualifications',
	];

	protected $hidden = [];

	protected $casts = [];

	protected $appends = [];

	### Accessors

	### Mutators

	### Relationships

	### Extend relationships

	### Methods
	public function scopeActive($query)
	{
		return $query->where('status',1);
	}

	### Static Methods
}
