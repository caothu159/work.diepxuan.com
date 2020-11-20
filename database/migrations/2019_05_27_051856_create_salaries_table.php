<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nam');
            $table->unsignedBigInteger('thang');
            $table->unsignedBigInteger('ngay')->nullable();

            $table->string('name');
            $table->double('luongcoban');
            $table->double('baohiem')->nullable();
            $table->double('chitieu')->nullable();
            $table->double('heso')->nullable();
            $table->double('tile')->nullable();

            $table->double('chamcong')->nullable();
            $table->string('diadiem')->nullable();
            $table->double('doanhso')->nullable();
            $table->double('chono')->nullable();
            $table->double('thuno')->nullable();

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
        Schema::dropIfExists('salaries');
    }
}
