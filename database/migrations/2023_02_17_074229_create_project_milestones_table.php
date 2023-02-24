<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_milestones', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('project_id');
            $table->string('milestone',200);
            $table->date('mile_start_date');
            $table->date('mile_end_date');
            $table->integer('levels_to_be_crossed');
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('project_milestones');
    }
}
