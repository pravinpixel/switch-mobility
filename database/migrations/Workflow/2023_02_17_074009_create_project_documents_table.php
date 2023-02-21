<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_documents', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('original_name');
            $table->integer('type');
            $table->integer('project_id');
            $table->integer('project_level');
            $table->string('document');
            $table->string('remark');
            $table->integer('is_latest');
            $table->integer('status');
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
        Schema::dropIfExists('project_documents');
    }
}
