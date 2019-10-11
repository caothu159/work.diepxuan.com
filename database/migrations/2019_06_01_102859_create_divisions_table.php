<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
