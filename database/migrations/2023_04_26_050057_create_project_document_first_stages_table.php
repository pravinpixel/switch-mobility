<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDocumentFirstStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_document_first_stages', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('project_id');
            $table->integer('doc_id');
            $table->integer('level_id');
            $table->string('file_name',200)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            
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
        Schema::dropIfExists('project_document_first_stages');
    }
}
