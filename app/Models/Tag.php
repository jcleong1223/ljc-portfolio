<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Pylon\Models\Traits\HasSoftDeletesActivity;
use Pylon\Models\Traits\HasSortColumn;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasModelableFile;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
	use HasSoftDeletesActivity;
	use HasSortColumn;
	use HasModelKit;
	use HasModelableFile;

    protected $fillable = ['title', 'level', 'status', 'icon'];

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
		return $this->image()->where('module_path', ModelableFile::MODULE_PATH_TAG_WEB_IMAGE);
	}

    ### Methods

    ### Static Methods
}
