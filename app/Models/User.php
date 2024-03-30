<?php

namespace App\Models;

use App\Library\RoleTag;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Pylon\Models\Traits\HasModelableFile;
use Pylon\Models\Traits\HasModelKit;
use Pylon\Models\Traits\HasSoftDeletesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasFactory;
	use Notifiable;
	use HasRoles;
	use SoftDeletes;
	use HasApiTokens;
	use HasModelKit;
	use HasSoftDeletesActivity;
	use HasModelableFile;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'email_verified_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $appends = [];

	### Accessors

	### Mutators

	### Relationships
	public function avatar()
	{
		return $this->morphOne(ModelableFile::class, 'modelable')->withDefault(ModelableFile::defaultImage('v1.png', 'default/avatar'));
	}

	### Extend relationships

	### Methods
	public function isSuperAdmin(): bool
	{
		return $this->hasRole(RoleTag::getAdminRoles());
	}

	public function isNexusAdmin(): bool
	{
		return $this->hasRole(RoleTag::NEXUS_SUPER_ADMIN);
	}

	public function hasExistingPassword()
	{
		return $this->attributes['password'] != 'p@ssw0rd';
	}

	### Static Methods

	// Notifiable
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}
}
