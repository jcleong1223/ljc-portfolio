<?php

use App\Models\ModelableFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelableFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modelable_files', function (Blueprint $table)
		{
			$table->id();
			$table->string('name');
			$table->string('file_type_key');
			$table->string('disk');
			$table->string('module_path');
			$table->morphs('modelable');
			$table->string('mime_type')->default('');
			$table->string('extension')->default('');
			$table->unsignedInteger('size')->default(0);
			$table->unsignedInteger('priority')->default(0);
			$table->unsignedInteger('folder_type_key')->default(ModelableFile::FOLDER_TYPE_MODEL_ID);
			$table->string('thumbnail')->nullable();
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
		Schema::dropIfExists('modelable_files');
	}
}
