<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

use App\SalaryUser;
use Illuminate\Http\Request;

class SalaryUserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([
            'clearcache',
        ]);

        $this->middleware([
            'auth',
        ])->except([
            'index',
            'show',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $time = null)
    {
        $salaryUsers = SalaryUser::select('ten', 'luongcoban', 'baohiem', 'chitieu', 'heso', 'tile')
            ->groupBy('ten')
            ->orderBy('nam', 'DESC')
            ->orderBy('thang', 'DESC')
            ->where([
                ['ten', '<>', '*'],
                ['ten', '<>', 'duc'],
            ])
            ->get()
        ;

        return response()->json([
            'users' => $salaryUsers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thang' => 'required',
            'nam'   => 'required',
            'ten'   => 'required',
        ]);

        $user = SalaryUser::updateOrCreate([
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => strtolower($request->input('ten')),
        ], [
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => strtolower($request->input('ten')),

            'luongcoban' => $request->input('luongcoban'),
            'baohiem'    => $request->input('baohiem'),
            'chitieu'    => $request->input('chitieu'),
            'heso'       => $request->input('heso'),
            'tile'       => $request->input('tile'),
        ]);

        if ($request->input('isJsonResponse')) {
            return response()->json([
                'user' => $user,
            ]);
        }

        $redirect = [
            'thoigian' => implode('-', [$request->input('thang'), $request->input('nam')]),
            'ten'      => $request->input('ten'),
        ];

        return redirect()->route('luong.home', $redirect);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'thang' => 'required',
            'nam'   => 'required',
            'ten'   => 'required',
        ]);

        SalaryUser::updateOrCreate([
            'id'    => $id,
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => $request->input('ten'),
        ], [
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => $request->input('ten'),

            'luongcoban' => $request->input('luongcoban'),
            'baohiem'    => $request->input('baohiem'),
            'chitieu'    => $request->input('chitieu'),
            'heso'       => $request->input('heso'),
            'tile'       => $request->input('tile'),
        ]);

        $redirect = [
            'thoigian' => implode('-', [$request->input('thang'), $request->input('nam')]),
            'ten'      => $request->input('ten') ?: false,
        ];

        return redirect()->route('salary.index', $redirect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
