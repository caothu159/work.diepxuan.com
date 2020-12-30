<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctumuahang;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MuahangController extends Controller
{

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
    public function index(Request $request, string $from = null, string $to = null)
    {
        if ($this->isRedirect) {
            return redirect()->route('muahang', [
                'from' => $request->input('from'),
                'to'   => $request->input('to'),
            ]);
        }

        $this->_updateDateInput($from, $to);
        $request->merge(['from' => $from]);
        $request->merge(['to' => $to]);
        $ctumuahangs = Ctumuahang::whereBetween('ngay_ct', [
            \DateTime::createFromFormat('d-m-Y', $request->input('from'))->format('Y-m-d'),
            \DateTime::createFromFormat('d-m-Y', $request->input('to'))->format('Y-m-d'),
        ])->get();

        return view('work.muahang.chungtu', [
            'ctumuahangs' => $ctumuahangs,
            'from'        => $from,
            'to'          => $to,
            'router'      => 'muahang',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function show(Ctumuahang $ctubanhang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function edit(Ctumuahang $ctubanhang)
    {
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
    public function update(Request $request, Ctumuahang $ctubanhang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ctumuahang $ctubanhang
     *
     * @return Response
     */
    public function destroy(Ctumuahang $ctubanhang)
    {
        //
    }
}
