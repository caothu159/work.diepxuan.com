<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productivities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('date');
            $table->decimal('productivity', 9, 0)->default(0);
            $table->decimal('in_debt', 9, 0)->default(0);
            $table->decimal('take_debt', 9, 0)->default(0);
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
        Schema::dropIfExists('productivities');
    }
}
