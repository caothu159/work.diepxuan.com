<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctubanhang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BanhangController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string|null $from
     * @param string|null $to
     *
     * @return mixed
     * @throws Exception
     */
    public function index( Request $request, string $from = null, string $to = null ) {
        if ( $this->isRedirect ) {
            return redirect()->route( 'banhang', [
                'from' => $request->input( 'from' ),
                'to'   => $request->input( 'to' )
            ] );
        }

        $this->_updateDateInput( $from, $to );
        $request->merge( [ 'from' => $from ] );
        $request->merge( [ 'to' => $to ] );
        $ctubanhangs = Ctubanhang::whereBetween( 'ngay_ct', [
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'from' ) )->format( 'Y-m-d' ),
            \DateTime::createFromFormat( 'd-m-Y', $request->input( 'to' ) )->format( 'Y-m-d' )
        ] )->get();

        return view( 'work.banhang.chungtu', [
            'ctubanhangs' => $ctubanhangs,
            'from'        => $from,
            'to'          => $to,
            'router'      => 'banhang',
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
     * @param Ctubanhang $ctubanhang
     *
     * @return Response
     */
    public function show( Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ctubanhang $ctubanhang
     *
     * @return void
     */
    public function edit( Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ctubanhang $ctubanhang
     *
     * @return Response
     */
    public function update( Request $request, Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ctubanhang $ctubanhang
     *
     * @return Response
     */
    public function destroy( Ctubanhang $ctubanhang ) {
        //
    }
}
