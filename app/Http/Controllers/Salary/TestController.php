<?php

/**
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

use App\Salary;
use App\Services\SalaryService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Undocumented class.
 */
class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $middleware = [
            'clearcache',
        ];
        $this->middleware($middleware);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  $salaryService                  App\Services\SalaryService
     * @param  $year                           string|null
     * @param  $month                          string|null
     * @throws Exception
     * @return Factory|\Illuminate\View\View
     */
    public function index(SalaryService $salaryService, string $year = null, string $month = null)
    {
        $viewData = [
            'controller' => $this,
            'service'    => $salaryService,
        ];

        return view('salary', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request   Request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thang' => 'required',
            'nam'   => 'required',
            'ten'   => 'required',
        ]);
        $tenLst = $request->input('ten');
        $tenLst = trim($tenLst);
        $tenLst = explode('-', $tenLst);
        foreach ($tenLst as $_ten) {
            $ten = trim($_ten);
            Salary::create([
                'ngay'     => $request->input('ngay'),
                'thang'    => $request->input('thang'),
                'nam'      => $request->input('nam'),
                'ten'      => $ten,
                'chamcong' => $request->input('chamcong'),
                'diadiem'  => $request->input('diadiem'),
                'doanhso'  => $request->input('doanhso'),
                'chono'    => $request->input('chono'),
                'thuno'    => $request->input('thuno'),
                'tile'     => 1 / count($tenLst),
            ]);
        }

        return redirect()->route('salary.index')->with(
            'thành công',
            "Đã thêm chấm công của <strong>$request->input('ten')</strong>."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  $id        int
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id        int
     * @return Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request   \Illuminate\Http\Request
     * @param  $id        int
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id        int
     * @return Response
     */
    public function destroy($id)
    {
        Salary::destroy($id);

        return redirect()->route('salary.index');
    }
}
