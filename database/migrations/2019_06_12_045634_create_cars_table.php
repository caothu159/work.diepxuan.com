<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'cars', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'name', 150 )->unique();
            $table->timestamps();
        } );

        Schema::table( 'presences', function ( Blueprint $table ) {
            $table->foreign( 'car_id' )->references( 'id' )->on( 'cars' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'presences', function ( Blueprint $table ) {
            $table->dropForeign( [ 'car_id' ] );
        } );
        Schema::dropIfExists( 'cars' );
    }
}
