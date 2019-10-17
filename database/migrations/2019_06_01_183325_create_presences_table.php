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
            $table->unsignedBigInteger( 'car_id' )->nullable();
            $table->unsignedBigInteger( 'date' );

            /** cham cong */
            $table->double( 'presence' )->nullable();
            /** luong cong nhat */
            $table->double( 'presence_salary' )->nullable();
            /** bao nhieu nguoi tren xe */
            $table->tinyInteger( 'salary_count' )->nullable();
            /** doanh so */
            $table->double( 'turnover' )->nullable();
            /** cho no */
            $table->double( 'in_debt' )->nullable();
            /** thu no */
            $table->double( 'take_debt' )->nullable();
            /** chia ti le */
            $table->float( 'percent', 6, 4 )->nullable();
            /** nang suat */
            $table->double( 'productivity' )->nullable();
            /** he so */
            $table->double( 'ratio' )->nullable();
            /** luong doanh so */
            $table->double( 'productivity_salary' )->nullable();

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
