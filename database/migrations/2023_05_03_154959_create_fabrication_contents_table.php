<?php

use App\Models\Fabrication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricationContentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fabrication_contents', function (Blueprint $table)
		{
			$table->id();
			$table->foreignIdFor(Fabrication::class)->constrained();
			$table->unsignedTinyInteger('seq_value')->default(1);
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
		Schema::dropIfExists('fabrication_contents');
	}
}
