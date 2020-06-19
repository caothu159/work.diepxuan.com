<?php

namespace App\Http\Controllers\Work\Factory;

use App\Model\Sync;
use App\Model\Work\Sanpham;

trait DongBoCtbh {
    protected $data = [];
    protected $from;
    protected $to;

    function dongboDmsp() {
        $dmsp = Sanpham::isSource()->isEnable()->get();
        $sync = Sync::where( 'type', 'ma_cty' )->first();
        foreach ( $dmsp as $sp ) {
            $_sp             = $sp;
            $_sp->sync->type = $sync->to;
            Sanpham::updateOrCreate( $_sp );
        }
    }
}
