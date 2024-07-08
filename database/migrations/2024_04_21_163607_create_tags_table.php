<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('level')->nullable(); // 1: Tag for User, 2: Tag for Project
            $table->string('icon')->nullable();
            $table->tinyInteger('status')->default(1); // 1:Active,0:Inactive
            $table->tinyInteger('my_skill')->default(0); // 1:True,0:False. If true, then can display in About Me "My Skills" section
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
        Schema::dropIfExists('tags');
    }
}
