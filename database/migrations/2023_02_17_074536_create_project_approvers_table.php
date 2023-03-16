<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_approvers', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('project_id');
            $table->integer('project_level_id');
            $table->integer('approver_id')->nullable(true);
            $table->integer('designation_id')->nullable(true);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')
                            ->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('project_level_id')->references('id')->on('project_levels') 
                            ->onUpdate('cascade')->onDelete('cascade');
       $table->foreign('designation_id')->references('id')->on('designations')
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
        Schema::dropIfExists('project_approvers');
    }
}
