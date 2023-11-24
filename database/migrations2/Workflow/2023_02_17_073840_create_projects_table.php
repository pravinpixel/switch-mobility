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
            $table->string('ticket_no')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('initiator_id');
            $table->integer('document_type_id');
            $table->integer('workflow_id');
            $table->string('role')->nullable();
            $table->integer('delete_flag')->default(0)->nullable();         
            $table->integer('is_active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('initiator_id')->references('id')->on('employees')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('document_type_id')->references('id')->on('document_types')
            ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
