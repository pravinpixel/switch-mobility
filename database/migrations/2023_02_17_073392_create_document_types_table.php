<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('name',150);
            $table->text('description')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('workflow_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable(true);
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
        Schema::dropIfExists('document_types');
    }
}
