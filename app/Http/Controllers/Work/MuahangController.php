<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctumuahang;
use Illuminate\Http\Request;

class MuahangController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string|null $from
     * @param string|null $to
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index( Request $request, string $from = null, string $to = null ) {
        $inputFrom = $request->input( 'from' );
        if ( $inputFrom == $from ) {
            $inputFrom = false;
        }
        $inputTo = $request->input( 'to' );
        if ( $inputTo == $to ) {
            $inputTo = false;
        }

        if ( $inputFrom ) {
            if ( $inputTo ) {
                return redirect()->route( 'muahang', [
                    'from' => $inputFrom,
                    'to'   => $inputTo,
                ] );
            }

            return redirect()->route( 'muahang', [
                'from' => $inputFrom,
            ] );
        }

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
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function show( Ctumuahang $ctubanhang ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Ctumuahang $ctubanhang ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( Ctumuahang $ctubanhang ) {
        //
    }
}
