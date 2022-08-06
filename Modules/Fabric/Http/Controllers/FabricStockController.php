<?php

namespace Modules\Fabric\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Fabric\Entities\FabricReceive;
use Modules\Fabric\Entities\Production;
use Modules\Fabric\Entities\FabricStock;
use Modules\Yarn\Entities\Party;
use Modules\Fabric\Entities\FabricDelivery;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;
use DB;

class FabricStockController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('fabric::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('fabric::create');
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
        return view('fabric::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('fabric::edit');
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

    public function getFabricStock(Request $request)
    {
        $parties = Party::all()->pluck('name', 'id');
        $stocks = $this->fabricStock($request)->paginate(10);
        return view('fabric::fabric_stock.all-stock', compact('stocks', 'parties'));
    }

    public function getFabricStockDetails($party_id)
    {
        // $stocks = FabricStock::where('party_id', $party_id)->orderBy('id', 'DESC')->get();
        $stocks = FabricStock::where('party_id', $party_id)->get();
        return view('fabric::fabric_stock.rec_fab_stock_details', compact('stocks', 'party_id'));
    }

    public function getProductionFabricStock(Request $request)
    {
        $prod_stocks = $this->productionStock($request)->paginate(10);
        $parties = Party::all()->pluck('name', 'id');
        return view('fabric::fabric_stock.production-stock', compact('prod_stocks', 'parties'));
    }

    public function getProductionFabricStockDetails(Request $request, $id)
    {
        $parties = Party::latest()->get();
        $productions = KnittingProductionDetail::where('party_id', $id)->get();
        $deliveryrolls = DB::table('knitting_production_details')
        ->Join('fabric_delivery_details', 'fabric_delivery_details.fab_delivery_id', '=', 'knitting_production_details.fabric_delivery_id')
        // ->select('party_id',DB::raw('sum(roll) as roll'))
        ->select('fabric_delivery_details.roll', 'knitting_production_details.*')
        ->where('party_id', $id)
        ->whereNull('knitting_production_details.deleted_at')
       ->get();
    //    dd($deliveryrolls);

        return view('fabric::fabric_stock.production-stock-details', compact('productions', 'parties', 'deliveryrolls'));
    }

    private function fabricStock($request)
    {
        $query = array();
        if ($request->party_id != null) {
            $query['party_id'] = $request->party_id;
        }
        $stockQuery  = FabricStock::where($query)->select('party_id', DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))->groupBy('party_id');

        $stock = $stockQuery->with(['party', 'receiveFabric']);
        return $stock;
    }
    private function productionStock($request)
    {
        $query = array();
        if ($request->party_id != null) {
            $query['party_id'] = $request->party_id;
        }
        $stockQuery  = KnittingProductionDetail::where($query)->select('party_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(roll) as roll'), DB::raw('sum(delivery_quantity) as delivery_quantity'), DB::raw('sum(delivery_roll_quantity) as delivery_roll_quantity'))->groupBy('party_id');

        $stock = $stockQuery->with(['party', 'knittingprogram']);
        return $stock;
    }
}
