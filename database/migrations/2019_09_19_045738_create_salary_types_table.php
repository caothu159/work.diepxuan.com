<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if ( Schema::hasTable( 'salary_types' ) ) {
            return;
        }

        Schema::create( 'salary_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->unsignedBigInteger( 'salary_id' );
            $table->string( 'name', 150 );
            $table->string( 'value', 150 );
            $table->timestamps();
        } );

        Schema::table( 'salary_types', function ( $table ) {
            $table->foreign( 'salary_id' )->references( 'id' )->on( 'salaries' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'salary_types' );
    }
}
