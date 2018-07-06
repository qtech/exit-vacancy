<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('user_id');
            $table->string('fname',255);
            $table->string('lname',255);
            $table->string('email',255);
            $table->string('password');
            $table->integer('role')->default(0);
            $table->integer('status')->default(0);
            $table->string('last_login',255)->nullable();
            $table->string('reset_token',255)->nullable();
            $table->integer('is_email_verify')->default(0);
            $table->integer('is_mobile_verify')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
