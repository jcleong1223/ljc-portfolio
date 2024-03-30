<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			InitSeeders\InitSeeder::class,
		]);

		if (app()->isLocal() && ($this->command->ask('Do you want to insert dummy data? (y/n)') == 'y'))
		{
			$this->call([FakeSeeders\FakeSeeder::class]);
		}
	}
}
