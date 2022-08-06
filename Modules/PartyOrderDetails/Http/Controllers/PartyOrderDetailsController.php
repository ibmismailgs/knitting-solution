<?php

namespace Modules\PartyOrderDetails\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\KnittingProgram;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\Yarn\Entities\Party;
use Modules\Fabric\Entities\FabricReceive;
use Modules\Fabric\Entities\FabricDelivery;
use Modules\Yarn\Entities\ReturnYarn;
use Modules\Yarn\Entities\Stock;
use Modules\Fabric\Entities\Production;
use Illuminate\Support\Facades\Validator;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;

use DB;

class PartyOrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $parties = Party::latest()->get();
        $total_party = count($parties);
        return view('partyorderdetails::details.index', compact('parties', 'total_party'));
    }

    public function orderlist($id)
    {
        // $party = Party::where('id', $id)->first();
        $party = Party::find($id);
        $order = KnittingProgram::with('party')->where('party_id', $party->id)->latest()->get();
        $total = count($order);
        return view('partyorderdetails::details.order_list', compact('party', 'order', 'total'));
    }

    public function orderdetails($id)
    {
        $knitting_id = KnittingProgram::where('id', $id)->first();
        $knitting_detail = YarnKnittingDetails::where('knitting_id', $knitting_id->id)->first();
        $fabric = FabricDelivery::where('delivery_type', 2)->where('fabric_deliveries.knitting_id', $knitting_id->id)
            ->join('fabric_delivery_details', 'fabric_delivery_details.fab_delivery_id', '=', 'fabric_deliveries.id')
            ->select('fabric_delivery_details.knitting_id', DB::raw('sum(fabric_delivery_details.quantity) as quantity'), DB::raw('sum(fabric_delivery_details.roll) as roll'))
            ->select('fabric_deliveries.*', 'fabric_delivery_details.roll', 'fabric_delivery_details.quantity')
            ->whereNULL('fabric_delivery_details.deleted_at')
            ->get();
        // dd($fabric);

        $fabric_stock  =  Production::where('productions.knitting_id', $knitting_id->id)
            ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
            ->select('knitting_production_details.knitting_id', DB::raw('sum(knitting_production_details.quantity) as quantity'), DB::raw('sum(knitting_production_details.roll) as roll'), DB::raw('sum(knitting_production_details.amount) as amount'))
            ->whereNull('knitting_production_details.deleted_at')
            ->groupBy('knitting_production_details.knitting_id')
            ->first();

        $stockdetails  = Production::where('productions.knitting_id', $knitting_id->id)
            ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
            ->select('knitting_production_details.knitting_id', DB::raw('sum(knitting_production_details.quantity) as quantity'), DB::raw('sum(knitting_production_details.roll) as roll'))
            ->select('productions.knitting_id', 'knitting_production_details.*')
            ->whereNull('knitting_production_details.deleted_at')
            ->get();

        $currentstocks  = KnittingProductionDetail::where('knitting_id', $knitting_id->id)
            ->select('knitting_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(roll) as roll'), DB::raw('sum(delivery_quantity) as delivery_quantity'), DB::raw('sum(delivery_roll_quantity) as delivery_roll_quantity'))
            ->groupBy('knitting_id')
            ->first();

            $current_yarn_stock = ($knitting_detail->knitting_qty) -(($fabric_stock->quantity ?? 0 ) +  ($knitting_detail->return_quantity ?? 0));

            // dd($current_yarn_stock);

        return view('partyorderdetails::details.view_details', compact('knitting_id', 'knitting_detail', 'fabric', 'fabric_stock', 'stockdetails', 'currentstocks', 'current_yarn_stock'));
    }

    public function fabricdetails($id)
    {
        $delivery_details = DB::table('fabric_delivery_details')->where('fab_delivery_id', $id)
            ->Join('fabric_deliveries', 'fabric_deliveries.id', '=', 'fabric_delivery_details.fab_delivery_id')
            ->join('yarn_parties', 'yarn_parties.id', '=', 'fabric_deliveries.party_id')
            ->join('yarn_knitting_program', 'yarn_knitting_program.id', '=', 'fabric_deliveries.knitting_id')
            ->select('fabric_delivery_details.rate as drate', 'fabric_delivery_details.quantity', 'fabric_delivery_details.amount', 'fabric_delivery_details.roll as droll', 'fabric_delivery_details.dia_gauza', 'fabric_deliveries.*', 'yarn_parties.name', 'yarn_knitting_program.party_order_no')

           ->whereNull('fabric_delivery_details.deleted_at')
           ->whereNull('fabric_deliveries.deleted_at')
           ->whereNull('yarn_parties.deleted_at')
           ->whereNull('yarn_knitting_program.deleted_at')

            ->first();
        // dd($delivery_details);
        return view('partyorderdetails::details.view_delivery', compact('delivery_details'));
    }

    // closeproduction

    public function closeproduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'return_quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        // $stock = YarnKnittingDetails::where('knitting_id', $request->knitting_id)->first();
        $yarn_stock = Stock::where('knitting_id', $request->knitting_id)->first();

        $yarn_return = YarnKnittingDetails::where('knitting_id', $request->knitting_id)->first();
        if ($yarn_stock == null) {
            return redirect()->back()->with('error', "Data not found");
        } else {
            // $current_return = $stock->knitting_qty - $request->return_quantity;

            $current_stock_out = $yarn_stock->stock_out - $request->return_quantity;

            $current_yarn_return = $yarn_return->return_quantity + $request->return_quantity;

            // $stock->update([
            //     'knitting_qty' => $current_return,
            // ]);
            $yarn_stock->update([
                'stock_out' => $current_stock_out,
            ]);

            $yarn_return->update([
                'return_quantity' => $current_yarn_return,
            ]);
            return redirect()->back()->with('success', 'Yarn stock out successfully updated');
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('partyorderdetails::create');
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
        return view('partyorderdetails::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('partyorderdetails::edit');
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
}
