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
            $table->string('first_name',200);
            $table->string('middle_name',200)->nullable();
            $table->string('last_name',200)->nullable();
            $table->string('email',200);
            $table->string('mobile',200);
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->integer('sap_id');
            $table->string('profile_image',200)->nullable();
            $table->string('sign_image',200)->nullable();            
            $table->string('address',200)->nullable();
           
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
