<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigInteger('time');
            $table->string('salary_id');
            $table->decimal('Luong co ban', 9, 0);
            $table->float('_0', 6, 4);
            $table->float('_13', 6, 4);
            $table->float('_20', 6, 4);
            $table->float('_30', 6, 4);
            $table->float('_40', 6, 4);
            $table->float('_50', 6, 4);
            $table->float('_60', 6, 4);
            $table->float('_70', 6, 4);
            $table->float('_80', 6, 4);
            $table->float('Ti le', 6, 4);
            $table->string('Bat cap');
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
        Schema::dropIfExists('employees');
    }
}
