<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('project_name');
            $table->string('project_code');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('initiator_id');
            $table->integer('project_role_id');
            $table->integer('delete_flag')->default(0)->nullable();         
            $table->boolean('is_active')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('initiator_id')->references('id')->on('employees')
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
        Schema::dropIfExists('projects');
    }
}
