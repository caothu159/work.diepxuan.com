<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctubanhang;
use App\Model\Work\Khohang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TonghopController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function banhang( Request $request ) {
        $tuychon = $request->input( 'tuychon' ) ?: 'donhang';
        $this->_updateRequestInput( $request, true );
        $ctubanhangs = Ctubanhang::whereBetween( 'ngay_ct', [
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'from' ) )->format( 'Y-m-d' ),
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'to' ) )->format( 'Y-m-d' )
        ] )->{"nhom$tuychon"}()->get();

        return view( "work.tonghop.$tuychon", [
            'ctubanhangs' => $ctubanhangs,
            'from'        => $request->input( 'from' ),
            'to'          => $request->input( 'to' ),
            'tuychon'     => $tuychon,
            'khohangs'    => Khohang::isEnable()->get()
        ] );
    }

}
