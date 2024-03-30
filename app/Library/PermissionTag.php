<?php

namespace App\Library;

class PermissionTag
{
	################################## PERMISSIONS ##############################################

	public const PERMISSION_ACCESS_TO_ADMIN_PANEL = 'access-to-admin-panel';
	public const PERMISSION_ACCESS_TO_VUE_WEB = 'access-to-vue-web';
	public const PERMISSION_ACCESS_BACKEND_CONTENT = 'access-backend-content';

	public static function getAllPermissions(): array
	{
		return [
			self::PERMISSION_ACCESS_TO_ADMIN_PANEL,
			self::PERMISSION_ACCESS_BACKEND_CONTENT,
			self::PERMISSION_ACCESS_TO_VUE_WEB,
		];
	}
}
