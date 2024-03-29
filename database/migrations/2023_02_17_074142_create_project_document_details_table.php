<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDocumentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_document_details', function (Blueprint $table) {
            
            $table->increments('id')->unsigned(false);
            $table->integer('version')->nullable();
            $table->integer('project_id')->nullable(true);
            $table->integer('upload_level')->nullable(true);
            $table->integer('updated_by')->nullable(true);
            $table->integer('project_doc_id');
            $table->string('document_name',200)->nullable();
            $table->string('remark',200)->nullable();
            $table->integer('status')->nullable();
            $table->integer('is_latest')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('project_doc_id')->references('id')->on('project_documents')
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
        Schema::dropIfExists('project_document_details');
    }
}
