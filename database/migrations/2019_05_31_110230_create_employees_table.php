<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_id');
            $table->decimal('default', 9, 0);
            $table->float('_0', 6, 4);
            $table->float('_13', 6, 4);
            $table->float('_20', 6, 4);
            $table->float('_30', 6, 4);
            $table->float('_40', 6, 4);
            $table->float('_50', 6, 4);
            $table->float('_60', 6, 4);
            $table->float('_70', 6, 4);
            $table->float('_80', 6, 4);
            $table->float('percent', 6, 4);
            $table->string('with');
            $table->timestamps();
        });

        Schema::table('employees', function ($table) {
            $table->foreign('salary_id')->references('id')->on('salaries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
