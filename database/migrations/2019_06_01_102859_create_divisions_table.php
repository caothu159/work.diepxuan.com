<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('productivity_id')->nullable();
            $table->bigInteger('date');
            $table->tinyInteger('salary_count');
            $table->timestamps();
        });

        Schema::table('divisions', function ($table) {
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('productivity_id')->references('id')->on('productivities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
