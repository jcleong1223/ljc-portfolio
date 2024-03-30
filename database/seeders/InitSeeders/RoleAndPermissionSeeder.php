<?php

namespace Database\Seeders\InitSeeders;

use App\Library\PermissionTag;
use App\Library\RoleTag;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
	/**
	 * Create the initial roles and permissions.
	 *
	 * @return void
	 */
	public function run()
	{
		// Reset cached roles and permissions
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		// create permissions
		$permissions = collect(PermissionTag::getAllPermissions())->map(function ($item)
		{
			return [
				'name' => $item,
				'guard_name' => 'web',
			];
		});
		Permission::insert($permissions->toArray());

		// create roles and assign existing permissions
		$role = Role::create(['name' => RoleTag::USER, 'display_name' => 'User']);
		$role->givePermissionTo([
			PermissionTag::PERMISSION_ACCESS_TO_VUE_WEB,
		]);

		$role = Role::create(['name' => RoleTag::ADMIN, 'display_name' => 'Admin']);
		$role->givePermissionTo([
			PermissionTag::PERMISSION_ACCESS_TO_ADMIN_PANEL,
		]);
		$role = Role::create(['name' => RoleTag::CLIENT_SUPER_ADMIN, 'display_name' => 'Super Admin']);
		$role->givePermissionTo([
			PermissionTag::PERMISSION_ACCESS_TO_ADMIN_PANEL,
			PermissionTag::PERMISSION_ACCESS_BACKEND_CONTENT,
		]);

		$role = Role::create(['name' => RoleTag::NEXUS_SUPER_ADMIN, 'display_name' => 'Nexus Admin']);
		$role->givePermissionTo([
			PermissionTag::PERMISSION_ACCESS_TO_ADMIN_PANEL,
			PermissionTag::PERMISSION_ACCESS_BACKEND_CONTENT,
		]);
	}
}
