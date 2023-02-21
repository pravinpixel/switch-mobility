<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('name');
            $table->string('username');
            $table->string('email');
            $table->date('email_verified_at')->nullable();
            $table->integer('is_admin')->nullable();    
            $table->integer('is_super_admin')->nullable();
            $table->integer('auth_level')->nullable();
            $table->string('password');
            $table->integer('emp_id')->nullable();
            $table->integer('authority_type')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
