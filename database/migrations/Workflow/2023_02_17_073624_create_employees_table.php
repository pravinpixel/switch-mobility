<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->integer('dept_id');
            $table->integer('desg_id');
            $table->integer('sap_id');
            $table->string('profile_image')->nullable();
            $table->string('sign_image')->nullable();            
            $table->string('address')->nullable();
            $table->boolean('is_active')->nullable();
            $table->integer('delete_flag')->default(0)->nullable(); 
            $table->timestamps();
            $table->foreign('dept_id')->references('id')->on('departments')
                            ->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('desg_id')->references('id')->on('designations')
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
        Schema::dropIfExists('employees');
    }
}
