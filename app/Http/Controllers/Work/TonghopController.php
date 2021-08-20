<?php

namespace App\Http\Controllers\Work;

use App\Model\Work\Ctubanhang;
use Illuminate\Http\Request;

class TonghopController extends Controller
{
    protected $data = [];
    protected $from;
    protected $to;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @param string|null $from
     * @param string|null $to
     *
     * @return mixed
     */
    public function index(
        Request $request,
        string $from = null,
        string $to = null
    ) {
        if ($this->isRedirect) {
            return redirect()->route("tonghop", [
                "from" => $request->input("from"),
                "to" => $request->input("to"),
            ]);
        }

        $this->_updateDateInput($from, $to);
        $request->merge(["from" => $from]);
        $request->merge(["to" => $to]);
        $this->from = $from;
        $this->to = $to;

        $this->data = Ctubanhang::syncChange();

        return view("work.tonghop.tonghop", [
            "data" => $this->data,
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
     * @param string|null $from
     * @param string|null $to
     *
     * @return Response
     */
    public function store(
        Request $request,
        string $from = null,
        string $to = null
    ) {
        //
        return $this->index($request, $from, $to);
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
