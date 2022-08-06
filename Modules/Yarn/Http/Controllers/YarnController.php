<?php

namespace Modules\Yarn\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Stock;
use Modules\Yarn\Entities\Party;
use DB;

class YarnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('yarn::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('yarn::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('yarn::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('yarn::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    // Get stock of yarn
    public function stock(Request $request){
        $parties = Party::all()->pluck('name', 'id');
        $stocks = $this->__filter($request)->paginate(10);
        return view('yarn::stock.index', compact('stocks', 'parties'));
    }

    // Get stock of yarn
    public function stockDetails($party_id){
        
        $datas = Stock::where('party_id', $party_id)->get();
        return view('yarn::stock.stock_details', compact('datas', 'party_id'));
    }

    private function __filter($request)
    {
        $query = array();
        if ($request->party_id != null) {
            $query['party_id'] = $request->party_id;
        }
        $stockQuery  = Stock::where($query)->select('party_id', DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))->groupBy('party_id');

        $stock = $stockQuery->with(['party', 'receiveYarn']);
      
        return $stock;
    }
}
