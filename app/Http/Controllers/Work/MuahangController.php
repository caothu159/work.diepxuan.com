<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctumuahang;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MuahangController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string|null $from
     * @param string|null $to
     *
     * @return Factory|View
     * @throws Exception
     */
    public function index( Request $request, string $from = null, string $to = null ) {
        $this->_updateDateInput( $from, $to );

        $_from = \DateTime::createFromFormat( 'd-m-Y', $from );
        if ( ! $_from ) {
            $from  = date( '01-m-Y' );
            $_from = \DateTime::createFromFormat( 'd-m-Y', $from );
        }
        $_from = $_from->format( 'Y-m-d' );

        $_to = \DateTime::createFromFormat( 'd-m-Y', $to );
        if ( ! $_to ) {
            $to  = date( 'd-m-Y' );
            $_to = \DateTime::createFromFormat( 'd-m-Y', $to );
        }
        $_to = $_to->format( 'Y-m-d' );

        $ctumuahangs = Ctumuahang::whereBetween( 'ngay_ct', [ $_from, $_to ] )->get();

        return view( 'work.muahang.chungtu', [
            'ctumuahangs' => $ctumuahangs,
            'from'        => $from,
            'to'          => $to,
            'router'      => 'muahang',
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function show( Ctumuahang $ctubanhang ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function edit( Ctumuahang $ctubanhang ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function update( Request $request, Ctumuahang $ctubanhang ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function destroy( Ctumuahang $ctubanhang ) {
        //
    }
}
