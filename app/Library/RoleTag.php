<?php

namespace App\Library;

class RoleTag
{
	################################## ROLES ##############################################

	public const NEXUS_SUPER_ADMIN = 'nexus-super-admin';
	public const CLIENT_SUPER_ADMIN = 'client-super-admin';
	public const ADMIN = 'admin';
	public const USER = 'user';

	public static function getAllRoles(): array
	{
		return [
			self::NEXUS_SUPER_ADMIN,
			self::CLIENT_SUPER_ADMIN,
			self::ADMIN,
			self::USER,
		];
	}

	public static function getAdminRoles(): array
	{
		return [
			self::NEXUS_SUPER_ADMIN,
			self::CLIENT_SUPER_ADMIN,
			self::ADMIN,
		];
	}

	public static function getAdminOnlyRoles(): array
	{
		return [
			self::ADMIN,
		];
	}

	public static function getNonAdminRoles(): array
	{
		return [
			self::USER,
		];
	}
}
