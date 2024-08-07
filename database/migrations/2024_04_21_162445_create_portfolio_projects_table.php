<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
			$table->longText('description');
            $table->string('website_url', 150)->nullable();
            $table->tinyInteger('status')->default(1); // 1:Active,0:Inactive
            $table->unsignedInteger('seq_value')->default(1);
            $table->date('project_date')->nullable();
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
        Schema::dropIfExists('portfolio_projects');
    }
}
