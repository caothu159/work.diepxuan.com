<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'users', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'name', 150 )->nullable();
            $table->string( 'username' )->unique();
            $table->string( 'email' )->unique();
            $table->timestamp( 'email_verified_at' )->nullable();
            $table->string( 'password' );
            $table->string( 'salary_name' )->unique()->nullable();
            $table->tinyInteger( 'role' )->default( 0 );
            $table->rememberToken();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'users' );
    }
}
