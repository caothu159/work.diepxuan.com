<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

use App\Helpers\TimeHelper;
use App\Salary;
use App\Services\SalaryServiceInterface as SalaryService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Undocumented class.
 */
class SalaryController extends Controller
{
    use TimeHelper;

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
     * @param  $salaryService                  App\Services\SalaryService
     * @param  $year                           string|null
     * @param  $month                          string|null
     *
     * @throws Exception
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index(SalaryService $salaryService, Request $request, string $time = null, string $name = null)
    {
        $redirect = [];
        $salaryService->setTime($time)->setName($name);

        $timePost = $request->input('thoigian') ?: $salaryService->getTime();
        if ($timePost && $timePost !== $time) {
            $redirect['name'] = $name;
            $redirect['time'] = $timePost;
        }

        $namePost = $request->input('ten');
        if ('false' == $namePost) {
            $redirect['time'] = array_key_exists('time', $redirect) ? $redirect['time'] : $salaryService->getTime();
        } elseif ($namePost && $namePost !== $name) {
            $redirect['name'] = $namePost;
            $redirect['time'] = array_key_exists('time', $redirect) ? $redirect['time'] : $salaryService->getTime();
        }
        if (count($redirect) >= 1) {
            return redirect()->route('luong.home', $redirect);
        }

        $viewData = [
            'controller' => $this,
            'service'    => $salaryService,
        ];

        $_viewTemplate = 'salary0221';

        if ($salaryService->getMonth() >= 3 && $salaryService->getYear() >= 2021) {
            $_viewTemplate = 'salary';
        }

        return view($_viewTemplate, $viewData);
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
     *
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
        $salary = null;
        foreach ($tenLst as $_ten) {
            $ten    = trim($_ten);
            $salary = Salary::updateOrCreate([
                'ngay'  => $request->input('ngay'),
                'thang' => $request->input('thang'),
                'nam'   => $request->input('nam'),
                'ten'   => $ten,
            ], [
                'ngay'  => $request->input('ngay'),
                'thang' => $request->input('thang'),
                'nam'   => $request->input('nam'),
                'ten'   => strtolower($ten),

                'chamcong' => $request->input('chamcong'),
                'diadiem'  => $request->input('diadiem'),
                'doanhso'  => $request->input('doanhso'),
                'chono'    => $request->input('chono'),
                'thuno'    => $request->input('thuno'),
                'tile'     => $request->input('tile') ?: (1 / count($tenLst)),
            ]);

            if ($salary->chamcong == 0 || $salary->chamcong == '0' || $request->input('chamcong') == 0 || $request->input('chamcong') == '0') {
                $salary->delete();
            }
        }

        if ($request->input('isJsonResponse')) {
            return response()->json([
                'salary' => $salary,
            ]);
        }

        $redirect = [
            'thoigian' => implode('-', [$request->input('thang'), $request->input('nam')]),
            'ten'      => 1 == count($tenLst) ? $tenLst[0] : false,
        ];

        return redirect()->route('luong.home', $redirect)->with(
            'thành công',
            "Đã thêm chấm công của <strong>{$request->input}('ten')</strong>."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  $id        int
     *
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id        int
     *
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
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'thang' => 'required',
            'nam'   => 'required',
            'ten'   => 'required',
        ]);

        $salary = Salary::updateOrCreate([
            'id'    => $id,
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => $request->input('ten'),
        ], [
            'ngay'  => $request->input('ngay'),
            'thang' => $request->input('thang'),
            'nam'   => $request->input('nam'),
            'ten'   => $request->input('ten'),

            'chamcong' => $request->input('chamcong'),
            'diadiem'  => $request->input('diadiem'),
            'doanhso'  => $request->input('doanhso'),
            'chono'    => $request->input('chono'),
            'thuno'    => $request->input('thuno'),
            'tile'     => $request->input('tile'),
        ]);

        if ($salary->chamcong == 0 || $salary->chamcong == '0' || $request->input('chamcong') == 0 || $request->input('chamcong') == '0') {
            $salary->delete();
        }

        if ($request->input('isJsonResponse')) {
            return response()->json(
                [
                    'Salary' => $salary,
                ]
            );
        }

        $redirect = [
            'thoigian' => implode('-', [$request->input('thang'), $request->input('nam')]),
            'ten'      => $request->input('ten') ?: false,
        ];

        return redirect()->route('salary.index', $redirect)->with(
            'thành công',
            "Đã thêm chấm công của <strong>{$request->input}('ten')</strong>."
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id        int
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salary   = Salary::find($id);
        $redirect = [
            'thoigian' => implode('-', [$salary->thang, $salary->nam]),
            'ten'      => $salary->ten,
        ];
        Salary::destroy($id);

        return redirect()->route('salary.index', $redirect);
    }
}
