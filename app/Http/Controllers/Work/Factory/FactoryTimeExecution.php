<?php


namespace App\Http\Controllers\Work\Factory;


trait FactoryTimeExecution {

    protected function applyLongTimeExecution( int $time = 0 ) {
        set_time_limit( $time );
        ini_set( 'max_execution_time', $time );
    }
}
