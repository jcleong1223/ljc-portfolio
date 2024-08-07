<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('public_files', function (Blueprint $table)
		{
			$table->id();
			$table->string('name');
			$table->string('file_type_key');
			$table->string('module_path');
			$table->string('mime_type')->default('');
			$table->string('extension')->default('');
			$table->unsignedInteger('size')->default(0);
			$table->softDeletes();
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
		Schema::dropIfExists('public_files');
	}
}
