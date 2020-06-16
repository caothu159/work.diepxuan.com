<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctubanhang;
use App\Model\Work\Khohang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TonghopController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @param string|null $from
     * @param string|null $to
     *
     * @return mixed
     */
    public function index( Request $request, string $from = null, string $to = null ) {
        if ( $this->isRedirect ) {
            return redirect()->route( 'tonghop', [
                'from' => $request->input( 'from' ),
                'to'   => $request->input( 'to' )
            ] );
        }

        $this->_updateDateInput( $from, $to );
        $request->merge( [ 'from' => $from ] );
        $request->merge( [ 'to' => $to ] );
        $request->merge( [ 'tuychon' => $request->input( 'tuychon' ) ?: 'donhang' ] );
        $request->merge( [ 'khohang' => $request->input( 'khohang' ) ?: 'all' ] );
        $ctubanhangs = Ctubanhang::whereBetween( 'ngay_ct', [
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'from' ) )->format( 'Y-m-d' ),
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'to' ) )->format( 'Y-m-d' )
        ] )->{"nhom" . $request->input( 'tuychon' )}()->nhomkhohang( $request->input( 'khohang' ) )->get();

        return view( "work.tonghop." . $request->input( 'tuychon' ), [
            'ctubanhangs' => $ctubanhangs,
            'khohangs'    => Khohang::isEnable()->get()
        ] );
    }

}
