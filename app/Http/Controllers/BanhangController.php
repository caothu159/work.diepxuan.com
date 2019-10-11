<?php

namespace App\Http\Controllers;

use App\Ctubanhang;
use Illuminate\Http\Request;

class BanhangController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $ctubanhangs = \App\Ctubanhang::where( 'nam', 2019 )
                                      ->whereIn( 'thang', [ 9, 10 ] )
                                      ->get();

        return view( 'work.banhang', [
            'ctubanhangs' => $ctubanhangs,
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
     * @param \App\Ctubanhang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function show( Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ctubanhang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ctubanhang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Ctubanhang $ctubanhang ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ctubanhang $ctubanhang
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( Ctubanhang $ctubanhang ) {
        //
    }
}
