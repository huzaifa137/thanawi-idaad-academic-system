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

            $table->id();
            $table->text('username')->nullable();
            $table->text('email')->nullable();
            $table->text('password')->nullable();
            $table->integer('user_role')->default(0);
            $table->integer('temp_otp')->nullable();
            $table->integer('registration_status')->default(0);
            $table->text('firstname')->nullable();
            $table->text('lastname')->nullable();
            $table->text('gender')->nullable();
            $table->text('phonenumber')->nullable();
            $table->integer('account_status')->default(10);
            $table->text('country')->nullable();
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
