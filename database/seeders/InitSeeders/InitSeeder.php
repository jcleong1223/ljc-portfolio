<?php

namespace Database\Seeders\InitSeeders;

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			GeneralSettingSeeder::class,
			RoleAndPermissionSeeder::class,
			UserSeeder::class,
		]);
	}
}
