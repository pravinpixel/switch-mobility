<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_levels', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('workflow_id');
            $table->integer('levels');
            $table->integer('approver_designation');
            $table->integer('is_active');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('workflow_id')->references('id')->on('workflows')
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
        Schema::dropIfExists('workflow_levels');
    }
}
