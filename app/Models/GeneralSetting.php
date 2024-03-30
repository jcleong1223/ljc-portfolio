<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pylon\Models\Traits\HasModelKit;

class GeneralSetting extends Model
{
	use HasFactory;
	use HasModelKit;

	protected $fillable = [
		'content',
		'description',
	];

	protected $hidden = [];

	protected $casts = [];

	// Data Types
	public const DATA_TYPE_BOOLEAN = 'boolean';
	public const DATA_TYPE_FLOAT = 'float';
	public const DATA_TYPE_JSON = 'json';
	public const DATA_TYPE_STRING = 'string';

	// GROUPS & KEYS
	// const GROUP_APP_VERSION = 'app_version';
	// const KEY_ANDROID_VERSION = 'android';
	// const KEY_IOS_VERSION = 'ios';
	// const KEY_ANDROID_VERSION_DESCRIPTION = 'android_description';
	// const KEY_IOS_VERSION_DESCRIPTION = 'ios_description';
	// const KEY_BLOCK_APP_ACCESS = 'block_app_access';
	// const KEY_IS_TEST_ENV = 'is_test_env';

	// const GROUP_APP_ENDPOINT = 'app_endpoint';
	// const KEY_STAGING_API_ENDPOINT = 'staging_api_endpoint';
	// const KEY_PRODUCTION_API_ENDPOINT = 'production_api_endpoint';
	// const KEY_STAGING_WEB_ENDPOINT = 'staging_web_endpoint';
	// const KEY_PRODUCTION_WEB_ENDPOINT = 'production_web_endpoint';
	// const KEY_STAGING_HIDE_SOCIALIZE_LOGIN = 'staging_hide_socialize_login';
	// const KEY_PRODUCTION_HIDE_SOCIALIZE_LOGIN = 'production_hide_socialize_login';

	public const GROUP_APP_SETTING = 'app_setting';

	protected $appends = ['value'];

	### Accessors
	public function getValueAttribute()
	{
		return $this->castValueToContent();
	}

	public function getIsEditableAttribute()
	{
		$authUser = auth()->user();
		return $authUser->isNexusAdmin() ? true : $this->attributes['is_editable'];
	}

	### Mutators
	public function setContentAttribute($content)
	{
		$this->attributes['content'] = $this->castContentToValue($content);
	}

	### Relationships

	### Extend relationships

	### Methods
	public function castValueToContent()
	{
		switch ($this->data_type)
		{
			case self::DATA_TYPE_BOOLEAN:
				return $this->content == 'true';
				break;
			case self::DATA_TYPE_FLOAT:
				return (float) $this->content;
				break;
			case self::DATA_TYPE_JSON:
				return json_decode($this->content);
				break;
			default:
				return $this->content;
				break;
		}
	}

	public function castContentToValue($content)
	{
		switch ($this->data_type)
		{
			case self::DATA_TYPE_BOOLEAN:
				return ($content == true) ? 'true' : 'false';
				break;
			case self::DATA_TYPE_JSON:
				return json_encode($content);
				break;
			default:
				return $content;
				break;
		}
	}

	### Static Methods
}
