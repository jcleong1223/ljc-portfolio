<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Pylon\Models\Traits\HasModelableFile;

class CareerApplication extends Model
{
    use HasFactory, SoftDeletes, HasModelableFile;

    protected $fillable = [
        "career_id",
        "applicant_name",
        "position_applied",
        "email",
        "phone",
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $appends = [];

    ### Accessors

    ### Mutators

    ### Relationships
    public function file()
	{
		return $this->morphOne(ModelableFile::class, 'modelable')->where('module_path', ModelableFile::MODULE_PATH_CAREER_RESUME_FILE);
	}

    ### Extend relationships
	// public function resumeFile(): MorphOne
	// {
	// 	return $this->where('module_path', ModelableFile::MODULE_PATH_CAREER_RESUME_FILE);
	// }

    ### Methods

    ### Static Methods
}
