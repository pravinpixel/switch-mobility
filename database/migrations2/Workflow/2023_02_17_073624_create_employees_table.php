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
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->integer('sap_id');
            $table->string('profile_image')->nullable();
            $table->string('sign_image')->nullable();            
            $table->string('address')->nullable();
           
            $table->integer('delete_flag')->default(0)->nullable(); 
            $table->integer('is_active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable(true);
            $table->foreign('department_id')->references('id')->on('departments')
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
        Schema::dropIfExists('employees');
    }
}
