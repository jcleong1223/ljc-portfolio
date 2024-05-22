<?php

use App\Models\PortfolioProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_contents', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(PortfolioProject::class)->constrained();
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
        Schema::dropIfExists('project_contents');
    }
}
