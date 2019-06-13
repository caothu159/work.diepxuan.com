<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150)->unique();
            $table->timestamps();
        });

        Schema::table('divisions', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->after('salary_id');
            $table->foreign('car_id')->references('id')->on('cars');
        });

        Schema::table('productivities', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->after('month');
            $table->foreign('car_id')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
