<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('general_settings', function (Blueprint $table)
		{
			$table->id();
			$table->string('group');
			$table->string('key');
			$table->text('content');
			$table->string('data_type');
			$table->unsignedTinyInteger('is_editable')->default(0);
			$table->string('description')->default('-');
			$table->unsignedTinyInteger('access_level')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('general_settings');
	}
}
