<?php
namespace App\Modules\Api\Controllers;

// use App\Http\Controllers\Controller as BaseController;
use App\Modules\Api\Controllers\BaseController as BaseController;
use App\Models\Work\Ctubanhang;
use Illuminate\Http\Request;
use App\Modules\Api\Resources\CtubanhangResource;

class CtubanhangController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @param string|null $year
     * @param string|null $month
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        // return $this->sendResponse([
            // $request->input('from'),
            // $request->input('to'),
            // \DateTime::createFromFormat('d/m/Y', $request->input('from')),
            // 'from' => \DateTime::createFromFormat('d-m-Y', $request->input('from'))->format('Y-m-d'),
            // 'to'   => \DateTime::createFromFormat('d-m-Y', $request->input('to'))->format('Y-m-d'),
        // ]);
        $ctubanhangs = Ctubanhang::whereBetween('ngay_ct', [
            \DateTime::createFromFormat('d/m/Y', $request->input('from'))->format('Y-m-d'),
            \DateTime::createFromFormat('d/m/Y', $request->input('to'))->format('Y-m-d'),
        ])->orderBy('ngay_ct', 'desc')->get();
        return CtubanhangResource::collection($ctubanhangs);
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
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
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
        return new CtubanhangResource(Ctubanhang::findOrFail($id));
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
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
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
