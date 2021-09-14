<?php

namespace App\Modules\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class WorkController extends BaseController
{

    /**
     * Instantiate a new controller instance.
     *
     * @param Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // $this->middleware(["admin", "clearcache"]);
        // $this->middleware(["auth", 'auth:sanctum'])->except('signin');
    }

    public function index()
    {
        return view('Api::work');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
}
