<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('time')->unique()->primary();
            $table->decimal('ns 01593', 9, 0);
            $table->decimal('no 01593', 9, 0);
            $table->decimal('thu no 01593', 9, 0);
            $table->decimal('ns 03166', 9, 0);
            $table->decimal('no 03166', 9, 0);
            $table->decimal('thu no 03166', 9, 0);
            $table->decimal('ns 05605', 9, 0);
            $table->decimal('no 05605', 9, 0);
            $table->decimal('thu no 05605', 9, 0);
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
