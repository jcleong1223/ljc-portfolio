<?php

namespace Database\Seeders\InitSeeders;

use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now();

		GeneralSetting::insert([
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_ANDROID_VERSION,
			//     'content' => '1.0.0',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_IOS_VERSION,
			//     'content' => '1.0.0',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_ANDROID_VERSION_DESCRIPTION,
			//     'content' => '',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_IOS_VERSION_DESCRIPTION,
			//     'content' => '',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_BLOCK_APP_ACCESS,
			//     'content' => 'false',
			//     "data_type" => GeneralSetting::DATA_TYPE_BOOLEAN,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_VERSION,
			//     'key' => GeneralSetting::KEY_IS_TEST_ENV,
			//     'content' => 'false',
			//     "data_type" => GeneralSetting::DATA_TYPE_BOOLEAN,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_STAGING_API_ENDPOINT,
			//     'content' => 'https://hana-game-api.testlab360.com/',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_PRODUCTION_API_ENDPOINT,
			//     'content' => 'https://api.mygamestore.com.my/',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_STAGING_WEB_ENDPOINT,
			//     'content' => 'https://hana-game-web.testlab360.com/',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_PRODUCTION_WEB_ENDPOINT,
			//     'content' => 'https://web.mygamestore.com.my/',
			//     "data_type" => GeneralSetting::DATA_TYPE_STRING,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_STAGING_HIDE_SOCIALIZE_LOGIN,
			//     'content' => 'true',
			//     "data_type" => GeneralSetting::DATA_TYPE_BOOLEAN,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
			// [
			//     'group' => GeneralSetting::GROUP_APP_ENDPOINT,
			//     'key' => GeneralSetting::KEY_PRODUCTION_HIDE_SOCIALIZE_LOGIN,
			//     'content' => 'true',
			//     "data_type" => GeneralSetting::DATA_TYPE_BOOLEAN,
			//     'is_editable' => 0,
			//     'created_at' => $now, 'updated_at' => $now,
			// 	"access_level" => 0,
			// ],
		]);
	}
}
