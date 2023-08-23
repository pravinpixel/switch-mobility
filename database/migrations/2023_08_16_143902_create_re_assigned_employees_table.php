<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReAssignedEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_assigned_employees', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('workflow_id');
            $table->integer('project_id')->nullable();
            $table->integer('level');
            $table->string('type');
            $table->integer('old_employee_id');
            $table->integer('new_employee_id'); 
            $table->date('assigned_date')->dafault(DB::raw('CURRENT_DATE'));        
            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_assigned_employees');
    }
}
