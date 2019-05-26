<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

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
            $table->bigIncrements('id');
            $table->string('name', 150)->nullable()->comment('User\'s fullname/nickname');
            $table->string('username')->unique()->comment('User\'s username to login');
            $table->string('email')->unique()->comment('User\'s email');
            $table->timestamp('email_verified_at')->nullable()->comment('The time verified email');
            $table->string('password')->comment('User\'s password');
            $table->boolean('is_admin')->default(false)->comment('User\'s role');
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
