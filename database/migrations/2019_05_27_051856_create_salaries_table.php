<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'salaries', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'name' );
            $table->unsignedBigInteger( 'month' );

            /** cham cong */
            $table->double( 'presence' );
            /** luong cung */
            $table->double( 'salary_default' );
            /** doanh so */
            $table->double( 'turnover' );
            /** luong san pham */
            $table->double( 'productivity' );
            /** luong */
            $table->double( 'salary' );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'salaries' );
    }
}
