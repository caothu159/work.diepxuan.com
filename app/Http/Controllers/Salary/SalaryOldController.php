<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

namespace App\Http\Controllers\Salary;

use App\Helpers\TimeHelper;
use App\Model\Salary\Sheet;
use App\Salary;
use App\Services\DatafileService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @deprecated 032021
 */
class SalaryOldController extends Controller
{
    use TimeHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'clearcache',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|\Illuminate\View\View
     *
     * @throws Exception
     */
    public function index(string $year = null, string $month = null)
    {
        return view('home', [
            'controller' => $this,
            'time'       => [
                'year'  => $year,
                'month' => $month,
            ],
            'data'       => $this->_loadSalary($year, $month),
        ]);
    }

    /**
     * [sheet description].
     *
     * @param Request     $request [description]
     * @param string|null $year    [description]
     * @param string|null $month   [description]
     *
     * @return [type] [description]
     */
    public function sheet(Request $request, string $year, string $month, string $filename)
    {
        $sheet = new Sheet($filename, $year, $month);

        return $sheet->download();
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
     * Import Data from file to database.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws Exception
     */
    public function import(DatafileService $datafileService, string $year = null, string $month = null)
    {
        $datafileService->salaryImport($year ?: date('Y'), $month ?: date('m'));

        return redirect()->route('salary.index', [
            'year'  => $year,
            'month' => $month,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
    }

    /**
     * Get salaries to show.
     *
     * @return Collection $collection
     *
     * @throws Exception
     */
    protected function _loadSalary(string $year = null, string $month = null)
    {
        $dt = sprintf('%s-%s', $year ?: date('Y'), $month ?: (date('m') . ' -1 month'));

        $month = new \DateTime($dt);
        $month = $month->getTimestamp() / (24 * 60 * 60) + 25569;

        return Salary::where('month', $month)->orderBy('name', 'asc')->get();
    }
}
