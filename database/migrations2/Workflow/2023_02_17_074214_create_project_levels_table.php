<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_levels', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('project_id');
            $table->date('due_date');
            $table->integer('project_level');
            $table->integer('priority');
            $table->integer('staff')->nullable();          
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_levels');
    }
}
