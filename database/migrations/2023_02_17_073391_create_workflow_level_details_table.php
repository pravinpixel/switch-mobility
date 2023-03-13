<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowLevelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_level_details', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('workflow_id');
            $table->integer('workflow_level_id');
            $table->integer('designation_id')->nullable();
            $table->integer('employee_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('workflow_id')->references('id')->on('workflows')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('workflow_level_id')->references('id')->on('workflow_levels')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')
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
        Schema::dropIfExists('workflow_level_details');
    }
}
