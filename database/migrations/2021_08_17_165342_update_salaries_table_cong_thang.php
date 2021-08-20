<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalariesTableCongThang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn("salaries", "congthang")) {
            return;
        }
        Schema::table("salaries", function (Blueprint $table) {
            $table
                ->string("congthang")
                ->after("luongcoban")
                ->nullable()
                ->default(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn("salaries", "congthang")) {
            Schema::table("salaries", function (Blueprint $table) {
                $table->dropColumn(["congthang"]);
            });
        }
    }
}
