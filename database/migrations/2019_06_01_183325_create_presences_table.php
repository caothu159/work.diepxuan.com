<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'presences', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->unsignedBigInteger( 'salary_id' );
            $table->unsignedBigInteger( 'car_id' )->after( 'salary_id' );
            $table->unsignedBigInteger( 'date' );

            /** cham cong */
            $table->double( 'presence' );
            /** luong cong nhat */
            $table->double( 'presence_salary' )->after( 'presence' );
            /** bao nhieu nguoi tren xe */
            $table->tinyInteger( 'salary_count' );
            /** doanh so */
            $table->double( 'turnover' );
            /** cho no */
            $table->double( 'in_debt' );
            /** thu no */
            $table->double( 'take_debt' );
            /** chia ti le */
            $table->float( 'percent', 6, 4 );
            /** nang suat */
            $table->double( 'productivity' );
            /** he so */
            $table->double( 'ratio' );
            /** luong san pham */
            $table->double( 'productivity_salary' );

            $table->timestamps();
        } );

        Schema::table( 'presences', function ( $table ) {
            $table->foreign( 'salary_id' )->references( 'id' )->on( 'salaries' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'presences' );
    }
}
