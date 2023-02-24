<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_authorities', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('name');
            $table->integer('auth_type_id');
            $table->integer('employee_type_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('auth_type_id')->references('id')->on('authority_types')
                            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employee_type_id')->references('id')->on('employee_types')
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
        Schema::dropIfExists('user_authorities');
    }
}
