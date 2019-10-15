<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctumuahang;
use Illuminate\Http\Request;

class MuahangController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( [
            'auth',
            'admin',
            'clearcache'
        ] );
//        $this->middleware('log')->only('index');
//        $this->middleware('subscribed')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $ctumuahangs = Ctumuahang::where( 'nam', 2019 )
                                 ->whereIn( 'thang', [ 10 ] )
                                 ->get();

        return view( 'work.muahang', [
            'ctumuahangs' => $ctumuahangs,
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
