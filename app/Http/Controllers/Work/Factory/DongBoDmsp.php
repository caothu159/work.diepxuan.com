<?php

namespace App\Http\Controllers\Work\Factory;

use App\Model\Sync;
use App\Model\Work\Nhomsanpham;
use App\Model\Work\Sanpham;

trait DongBoDmsp {
    use FactoryTimeExecution;

    protected $data = [];
    protected $from;
    protected $to;

    function dongboDmsp() {
        $this->applyLongTimeExecution();
        $sync = Sync::where( 'type', 'ma_cty' )->first();
        $dmsp = Sanpham::isSource()->isEnable()->get();
        foreach ( $dmsp as $sp ) {
            $_sp                = $sp;
            $_sp->{$sync->type} = $sync->to;
            $_sp                = Sanpham::updateOrCreate( [
                $sync->type => $_sp->{$sync->type},
                'ma_vt'     => $_sp->ma_vt,
            ], array_filter( $_sp->toArray() ) );
            if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
                echo "\r\e[32mSyncing:\e[0m $_sp->ma_vt - $_sp->ten_vt\033[K";
            }
        }
        if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
            echo "\r\n";
        }
    }

    function dongboDmnhsp() {
        $this->applyLongTimeExecution( 60 * 5 );
        $sync   = Sync::where( 'type', 'ma_cty' )->first();
        $dmnhsp = Nhomsanpham::isSource()->isEnable()->get();
        foreach ( $dmnhsp as $nhsp ) {
            $_nhsp                = $nhsp;
            $_nhsp->{$sync->type} = $sync->to;
            $_nhsp                = Nhomsanpham::updateOrCreate( [
                $sync->type => $_nhsp->{$sync->type},
                'ma_nhvt'   => $_nhsp->ma_nhvt,
            ], array_filter( $_nhsp->toArray() ) );
            if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
                echo "\r\e[32mSyncing:\e[0m $_nhsp->ma_nhvt - $_nhsp->ten_nhvt\033[K";
            }
        }
        if ( \App::runningInConsole() || strpos( php_sapi_name(), 'cli' ) !== false ) {
            echo "\r\n";
        }
    }
}
