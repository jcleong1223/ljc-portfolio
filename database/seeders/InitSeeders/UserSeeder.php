<?php

namespace Database\Seeders\InitSeeders;

use App\Library\RoleTag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Client Admin
		$email = 'admin@kploo.com';
		$password = Hash::make('kploo@1234');
		if (app()->isLocal())
		{
			$email = 'staging-admin@kploo.com';
			$password = Hash::make('1111aaaa');
		}
		$user = User::create([
			'name' => 'Admin',
			'email' => $email,
			'password' => $password,
		]);
		$user->assignRole(RoleTag::CLIENT_SUPER_ADMIN);

		// ETC Admin
		$user = User::create([
			'name' => 'ETC Admin',
			'email' => 'admin@etctech.com.my',
			'password' => Hash::make(app()->isLocal() ? '1111aaaa' : 'admin@1234'),
		]);
		$user->assignRole(RoleTag::NEXUS_SUPER_ADMIN);

		// Tester
		// $user = User::create([
		// 	'name' => 'app-tester',
		// 	'email' => 'apptester@etctech.com.my',
		// 	'password' => Hash::make(app()->isLocal() ? '1111aaaa' : 'tester@324'),
		// ]);
		// $user->assignRole(RoleTag::USER);
	}
}
