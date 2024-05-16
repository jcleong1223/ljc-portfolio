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

class PortfolioProject extends Model
{
    use HasFactory;
	use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasSortColumn;
	use HasModelKit;
	use HasModelableFile;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'status',
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
			->where('module_path', ModelableFile::MODULE_PATH_PORTFOLIO_IMAGE)
			->withDefault(ModelableFile::defaultImage());
	}

    public function mediaContents()
	{
		return $this->hasMany(ServiceContent::class)->orderBy('seq_value', 'ASC');
	}

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tags', 'project_id', 'tag_id')->withTimestamps();
    }

    ### Extend relationships
    public function webImage(): MorphOne
	{
		return $this->image()->where('module_path', ModelableFile::MODULE_PATH_PORTFOLIO_IMAGE);
	}

    ### Methods

    ### Static Methods
}
