<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('careers', function (Blueprint $table)
		{
			$table->id();
			$table->string('title');
			$table->text('location');
			$table->string('salary_range');
			$table->longText('description');
			$table->text('exp_required');
			$table->string('type');
			$table->string('career_level');
			$table->string('specializations');
			$table->string('qualifications');
			$table->integer('status');
			$table->unsignedInteger('seq_value')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('careers');
	}
}
