<?php

namespace Modules\Fabric\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bill;
use Illuminate\Support\Facades\Auth;
use Modules\Fabric\Entities\Production;
use Modules\Fabric\Entities\FabricReceive;
use Modules\Yarn\Entities\KnittingProgram;
use Modules\Fabric\Entities\FabricDelivery;
use Illuminate\Contracts\Support\Renderable;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;

class FabricDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $datas = FabricDelivery::where('delivery_type', 1)->get();
        return view('fabric::fabric_delivery.index', compact('datas', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();
        $fab_receives = FabricReceive::all();
        $feb_delivery = FabricDelivery::count();
        if(!empty($feb_delivery)){
            $feb_delivery++;
        }else{
            $feb_delivery = 0;
            $feb_delivery++;
        }
        //dd($feb_delivery);
        return view('fabric::fabric_delivery.create', compact('parties', 'fab_receives','feb_delivery'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required|numeric',
            'receive_id' => 'required|numeric',
            'chalan' => 'required',
            'gate_pass' => 'required',
            'order_no' => 'required',
            'stl_no' => 'required'
        ]);

        if($validated){
            DB::beginTransaction();

            try {
                // Store fabric delivery
                $input = $request->except(['rec_fab_id', 'stock_out', 'roll','rate', 'fab_rec_details_id']);
                $fab_del = FabricDelivery::create($input);

                $totalBill = 0; $totalQuantity = 0;
                foreach ($request->stock_out as $key => $value) {
                    if (isset($value) && $value > 0) {

                        // Calculate amount
                        $amount = $request->rate[$key] * $value;
                        $totalBill += $amount;
                        $totalQuantity += $value;

                        // Store fabric delivery details
                        DB::table('fabric_delivery_details')->insert([
                            'fab_delivery_id' => $fab_del->id,
                            'rec_fab_id' => $request->rec_fab_id[$key],
                            'fab_rec_details_id' => $request->fab_rec_details_id[$key],
                            'quantity' => $value,
                            'rate' => $request->rate[$key],
                            'roll' => $request->roll[$key],
                            'amount' => $amount
                        ]);

                        // febric receive details update
                        $quantity = DB::table('fabric_receive_details')->where('id',$request->fab_rec_details_id[$key])->first();
                        $final_quantity = ($quantity->stock - $request->stock_out[$key]);
                        $receive_quantity = [
                           'stock' => $final_quantity
                        ];
                        DB::table('fabric_receive_details')->where('id',$request->fab_rec_details_id[$key])->update($receive_quantity);
                    }
                }

                // Update total bill and quantity of fabric delivery
                $total_bill_and_kg = [
                    'bill' => $totalBill,
                    'kg' => $totalQuantity
                ];
                FabricDelivery::where('id', $fab_del->id)->update($total_bill_and_kg);

                // Update Fabric delivery stocks....
                DB::table('fabric_stocks')->insert([
                    'receive_id' => $request->receive_id,
                    'party_id' => $request->party_id,
                    'delivery_id' => $fab_del->id,
                    'stock_out' => $totalQuantity
                ]);

                DB::commit();
                // all good
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return 'something went wrong';
            }
        }
        return redirect()->route('fabric_delivery.index')
                        ->with('success','Fabric Delivery created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = FabricDelivery::find($id);
        $details = DB::table('fabric_delivery_details')
                  ->Join('fabric_receive_details','fabric_delivery_details.fab_rec_details_id','=','fabric_receive_details.id')
                  ->select('fabric_delivery_details.*','fabric_receive_details.lot','fabric_receive_details.count','fabric_receive_details.roll')
                  ->where('fab_delivery_id',$data->id)
                  ->whereNull('fabric_delivery_details.deleted_at')
                  ->get();
        return view('fabric::fabric_delivery.show', compact('data','details'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $parties = Party::all();
        $fab_receives = FabricReceive::all();
        $data = FabricDelivery::find($id);

        $fab_receive_details = DB::table('fabric_delivery_details')
        //->where('fab_rec_id', $data->receive_id)
        ->where('fab_delivery_id', $id)
        ->select('fabric_receive_details.lot', 'fabric_receive_details.count', 'fabric_receive_details.roll', 'fabric_receive_details.quantity as receive_quantity'
        , 'fabric_delivery_details.quantity as delivery_quantity', 'fabric_delivery_details.rate as rate', 'fabric_delivery_details.amount as amount'
        , 'fabric_delivery_details.rec_fab_id as rec_fab_id', 'fabric_delivery_details.fab_rec_details_id as fab_rec_details_id','fabric_delivery_details.roll as delivery_roll')
        ->join('fabric_receive_details', 'fabric_receive_details.id', 'fabric_delivery_details.fab_rec_details_id')
        ->whereNull('fabric_delivery_details.deleted_at')
        ->get();
        //dd($fab_receive_details);

        return view('fabric::fabric_delivery.edit', compact('parties', 'fab_receives', 'data', 'fab_receive_details'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required',
            'receive_id' => 'required',
            'chalan' => 'required',
            'gate_pass' => 'required',
            'order_no' => 'required',
            'stl_no' => 'required'
        ]);

        if($validated){
            DB::beginTransaction();

            try {
                //dd($request->stock_out);
                // Store fabric delivery
                $input = $request->except(['rec_fab_id', 'stock_out', 'rate', 'fab_rec_details_id','previous_stock']);
                $model = FabricDelivery::where('id',$id)->first();
                $model->update($input);

                if(isset($request->stock_out)){
                    // Delete previous pivot data of (fabric_delivery_details)
                    $delete = DB::table('fabric_delivery_details')->where('fab_delivery_id', $id)->delete();

                    $totalBill = 0; $totalQuantity = 0;
                    foreach ($request->stock_out as $key => $value) {
                        if (isset($value) && $value > 0) {
                            //dd($request->stock_out);
                            // Calculate amount
                            $amount = $request->rate[$key] * $value;
                            $totalBill += $amount;
                            $totalQuantity += $value;

                            // Store fabric delivery details
                            DB::table('fabric_delivery_details')->insert([
                                'fab_delivery_id' => $id,
                                'rec_fab_id' => $request->rec_fab_id[$key],
                                'fab_rec_details_id' => $request->fab_rec_details_id[$key],
                                'quantity' => $value,
                                'rate' => $request->rate[$key],
                                'roll' => $request->roll[$key],
                                'amount' => $amount
                            ]);

                            // febric receive details update
                            $quantity = DB::table('fabric_receive_details')->where('id',$request->fab_rec_details_id[$key])->first();

                            $balance = $request->previous_stock[$key] - $request->stock_out[$key];
                            $final_quantity = ($quantity->stock + $balance);
                            $receive_quantity = [
                            'stock' => $final_quantity
                            ];
                            DB::table('fabric_receive_details')->where('id',$request->fab_rec_details_id[$key])->update($receive_quantity);
                        }
                    }

                    // Update total bill and quantity of fabric delivery
                    $total_bill_and_kg = [
                        'bill' => $totalBill,
                        'kg' => $totalQuantity
                    ];
                    FabricDelivery::where('id', $id)->update($total_bill_and_kg);

                    // Delete previous stock data
                    DB::table('fabric_stocks')->where('delivery_id', $id)->delete();

                    // Update Fabric delivery stocks....
                    DB::table('fabric_stocks')->insert([
                        'receive_id' => $request->receive_id,
                        'party_id' => $request->party_id,
                        'delivery_id' => $id,
                        'stock_out' => $totalQuantity
                    ]);
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return redirect()->route('fabric_delivery.index')
                        ->with('success','error');
            }

        }
        return redirect()->route('fabric_delivery.index')
                        ->with('success','Fabric Delivery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $reference = Bill::where('delivery_id', $id)->first();
        if(isset($reference)){
            return redirect()->back()->with('errors','This data is used somewhere else!');
        }else{
            // Delete previous pivot data of (fabric_delivery_details)
            DB::table('fabric_delivery_details')->where('fab_delivery_id', $id)->delete();

            // Delete previous stock data
            DB::table('fabric_stocks')->where('delivery_id', $id)->delete();

            $model = FabricDelivery::findOrFail($id);
            $model->delete();
            return redirect()->route('fabric_delivery.index')
                            ->with('success','Fabric Delivery deleted successfully');
        }

    }

    public function fabricDeliveryDeliveryChallan($id){
        $delivery = FabricDelivery::findOrFail($id);
        $delivery_details = DB::table('fabric_delivery_details')
                        ->Join('fabric_receive_details','fabric_delivery_details.fab_rec_details_id','=','fabric_receive_details.id')
                        ->join('fabric_receive','fabric_receive.id','=','fabric_delivery_details.rec_fab_id')
                        ->select('fabric_delivery_details.*','fabric_receive_details.lot','fabric_receive_details.count','fabric_receive_details.roll','fabric_receive.buyer_name')
                        ->where('fab_delivery_id',$delivery->id)
                        ->whereNull('fabric_delivery_details.deleted_at')
                        ->get();
        //dd($delivery_details);
        return view('fabric::fabric_delivery.challan',compact('delivery','delivery_details'));
    }

    public function fabricDeliveryGatePass($id){
        $delivery = FabricDelivery::findOrFail($id);
        $delivery_details = DB::table('fabric_delivery_details')
                        ->Join('fabric_receive_details','fabric_delivery_details.fab_rec_details_id','=','fabric_receive_details.id')
                        ->join('fabric_receive','fabric_receive.id','=','fabric_delivery_details.rec_fab_id')
                        ->select('fabric_delivery_details.*','fabric_receive_details.lot','fabric_receive_details.count','fabric_receive_details.roll','fabric_receive.buyer_name')
                        ->where('fab_delivery_id',$delivery->id)
                        ->whereNull('fabric_delivery_details.deleted_at')
                        ->get();
        return view('fabric::fabric_delivery.gate_pass',compact('delivery','delivery_details'));
    }


    public function getFabricReceiveDetails(Request $request)
    {
        if(!empty($request->id)){
            $recFabric = DB::table('fabric_receive_details')->whereIn('fab_rec_id', $request->id)->where('quantity','>',0)->get();
        }else{
            $recFabric = '';
        }

        return response()->json([
            'recFabric'          => $recFabric
        ]);
    }

    public function getPartyInfo(Request $request){
        $fab_receives = FabricReceive::where('party_id', $request->id)->pluck('name', 'id')->toArray();
        return response()->json([
            'fab_receives'          => array_unique($fab_receives)
        ]);

    }

    /**
     * Fabric delivery from Production Started ...............
     */


    public function getFabricDeliveryListFromProduction()
    {
        // $datas = FabricDelivery::where('delivery_type', 2)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $datas =  DB::table('fabric_deliveries')
            ->whereNull('fabric_deliveries.deleted_at')
           ->where('delivery_type', 2)
            ->join('yarn_parties', 'yarn_parties.id', '=', 'fabric_deliveries.party_id')
            ->join('fabric_delivery_details', 'fabric_delivery_details.fab_delivery_id', '=', 'fabric_deliveries.id')
            ->select('fabric_deliveries.*', 'yarn_parties.name', 'yarn_parties.stl_no', 'fabric_delivery_details.quantity', 'fabric_delivery_details.roll')
            ->latest()
            ->get();
        return view('fabric::fabric_delivery_production.index', compact('datas', 'user_role'));
    }

    public function createFabricDeliveryFromProduction()
    {
        $parties = Party::all();
        $feb_delivery = FabricDelivery::count();
        // $knitting_programs = KnittingProgram::all();

        return view('fabric::fabric_delivery_production.create', compact('parties','feb_delivery'));
    }

    public function storeFabricDeliveryFromProduction(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'date' => 'required',
            'delivery_type' => 'required',
            'party_id' => 'required',
            'chalan' => 'required',
            'gate_pass' => 'required',
            'order_no' => 'required',
            'roll' => 'required'
        ]);

        if($validated){
            DB::beginTransaction();
            try {
                // Store fabric delivery
                $input = $request->all();
                $bill = array_sum($request->amount);
                $delivery = [
                    'delivery_type' => $request->delivery_type,
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'knitting_id' => $request->knitting_id[0],
                    'chalan' => $request->chalan,
                    'gate_pass' => $request->gate_pass,
                    'order_no' => $request->order_no,
                    'driver' => $request->driver,
                    'truck_number' => $request->truck_number,
                    'note' => $request->note,
                    'bill' => $bill,
                ];
                $fab_del = FabricDelivery::create($delivery);
                //Bill table data
                $bill_no = Bill::count();
                $bill = [
                    'delivery_id' => $fab_del->id,
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'is_paid' => 0,
                    'received_amount' => 0,
                    'amount' => $bill,
                    'created_by'=> Auth::id(),
                ];
                Bill::create($bill);
                //
                foreach ($request->stock_out as $key => $value) {
                    if (isset($value) && $value > 0) {

                        // Store fabric delivery details
                        DB::table('fabric_delivery_details')->insert([
                            'fab_delivery_id' => $fab_del->id,
                            'knitting_id' => $request->knitting_id[$key],
                            'yarn_knitting_details_id' => $request->yarn_knitting_details_id[$key],
                            'roll' => $request->roll[$key],
                            'dia_gauza' => $request->dia_gauza[$key],
                            'quantity' => $value,
                            'rate' => $request->rate[$key],
                            'amount' => $request->amount[$key]
                        ]);

                        // Fabric stock (Related to production) handeled from 'knitting_production_details' tables...
                        // Update Fabric delivery stocks....
                        DB::table('knitting_production_details')->insert([
                            'knitting_id' => $request->knitting_id[$key],
                            'yarn_knitting_details_id' => $request->yarn_knitting_details_id[$key],
                            'fabric_delivery_id' => $fab_del->id,
                            'party_id' => $input['party_id'],
                            'delivery_quantity' => $value,
                            'delivery_roll_quantity' => $request->roll[$key],
                        ]);

                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                // something went wrong
                return redirect()->route('fabric_delivery.index')
                        ->with('success','error');
            }

        }
        return redirect()->route('fabric_delivery.prod.index')
                        ->with('success','Fabric Delivery created successfully');
    }


    public function UpdateFabricDeliveryFromProduction(Request $request, $id)
    {
        //dd($request->all());
        $validated = $request->validate([
            'date' => 'required',
            'delivery_type' => 'required',
            'party_id' => 'required',
            'chalan' => 'required',
            'gate_pass' => 'required',
            'order_no' => 'required',
        ]);

        if($validated){
            // Update fabric delivery
            //DB::beginTransaction();
        try {
            $input = $request->all();
            $bill = array_sum($request->amount);
            $delivery = [
                'delivery_type' => $request->delivery_type,
                'date' => $request->date,
                'party_id' => $request->party_id,
                'knitting_id' => $request->knitting_id[0],
                'chalan' => $request->chalan,
                'gate_pass' => $request->gate_pass,
                'order_no' => $request->order_no,
                'driver' => $request->driver,
                'truck_number' => $request->truck_number,
                'note' => $request->note,
                'bill' => $bill,
            ];

            $model = FabricDelivery::findOrFail($id);
            $model->update($delivery);
            //dd($delivery);
            //bill table update
            $bill = [
                'date' => $request->date,
                'party_id' => $request->party_id,
                'is_paid' => 0,
                'received_amount' => 0,
                'amount' => $bill,
            ];
            $bill_update = Bill::where('delivery_id',$id)->first();
            $bill_update->update($bill);

            //Delete previous fabric delivery details
            DB::table('fabric_delivery_details')->where('fab_delivery_id', $id)->delete();

            //Delete previous Fabric stock details
            DB::table('knitting_production_details')->where('fabric_delivery_id', $id)->delete();

            foreach ($request->stock_out as $key => $value) {
                if (isset($value) && $value > 0) {

                    // Store fabric delivery details
                    DB::table('fabric_delivery_details')->insert([
                        'fab_delivery_id' => $id,
                        'knitting_id' => $request->knitting_id[$key],
                        'yarn_knitting_details_id' => $request->yarn_knitting_details_id[$key],
                        'roll' => $request->roll[$key],
                        'dia_gauza' => $request->dia_gauza[$key],
                        'quantity' => $value,
                        'rate' => $request->rate[$key],
                        'amount' => $request->amount[$key]
                    ]);


                    // Fabric stock (Related to production) handeled from 'knitting_production_details' tables...
                    // Update Fabric delivery stocks....
                    DB::table('knitting_production_details')->insert([
                        'knitting_id' => $request->knitting_id[$key],
                        'yarn_knitting_details_id' => $request->yarn_knitting_details_id[$key],
                        'fabric_delivery_id' => $id,
                        'party_id' => $input['party_id'],
                        'delivery_quantity' => $value
                    ]);
                }
            }
        } catch (\Exception $e) {
            //DB::rollback();
            // something went wrong
            return redirect()->route('fabric_delivery.index')
                    ->with('success','error');
        }
        }
        return redirect()->route('fabric_delivery.prod.index')
                        ->with('success','Fabric Delivery updated successfully');
    }

    public function showFabricDeliveryFromProduction($id){
        $data = FabricDelivery::find($id);
        $delivery_details = DB::table('fabric_delivery_details')
                            ->whereNull('fabric_delivery_details.deleted_at')
                            ->where('fab_delivery_id',$id)
                            ->join('yarn_knitting_details','fabric_delivery_details.yarn_knitting_details_id','=','yarn_knitting_details.id')
                            ->select('fabric_delivery_details.*','yarn_knitting_details.stl_order_no')
                            ->get();

        return view('fabric::fabric_delivery_production.show', compact('data','delivery_details'));
    }


    public function editFabricDeliveryFromProduction($id)
    {
        $parties = Party::all();
        // $knitting_programs = KnittingProgram::all();
        $data = FabricDelivery::find($id);
        $knitting_id = DB::table('fabric_delivery_details')->whereNull('deleted_at')->where('fab_delivery_id',$id)->pluck('yarn_knitting_details_id')->toArray();
        $delivery_details = DB::table('fabric_delivery_details')->where('fab_delivery_id',$id)->get();
        $knitting_programs = YarnKnittingDetails::whereIn('id',$knitting_id)->get();
        //dd($knitting_programs);

        $collectProducttion = [];
        $collectDelivery = [];
        $totalRollDelivery = [];
        foreach($knitting_id as $key=>$id){
             $production = KnittingProductionDetail::where('yarn_knitting_details_id',$id)->sum('quantity');
             $roll_production = KnittingProductionDetail::where('yarn_knitting_details_id',$id)->sum('roll');
             $roll_delivery = KnittingProductionDetail::where('yarn_knitting_details_id',$id)->sum('delivery_roll_quantity');
             $delivery = DB::table('fabric_delivery_details')->whereNull('deleted_at')->where('yarn_knitting_details_id',$id)->sum('quantity');
             $roll_stock = $roll_production - $roll_delivery ;
             array_push($collectProducttion,$production);
             array_push($collectDelivery,$delivery);
             array_push($totalRollDelivery, $roll_stock);
        }

        return view('fabric::fabric_delivery_production.edit', compact('parties','data','knitting_id','knitting_programs','delivery_details','collectProducttion','collectDelivery', 'totalRollDelivery'));
    }


    public function deleteFabricDeliveryFromProduction($id)
    {
        $reference = Bill::where('delivery_id', $id)->where('is_prepared','=',1)->first();
        if(isset($reference)){
            return redirect()->back()->with('errors','This data is used somewhere else!');
        }else{

            DB::table('fabric_delivery_details')->where('fab_delivery_id', $id)
                ->update(['deleted_at' => Carbon::now()]);
            // ->update(array('deleted_at' => Carbon::now()));

            // KnittingProductionDetail::where('fabric_delivery_id', $id)->delete();
            DB::table('knitting_production_details')->where('fabric_delivery_id', $id)->update(['deleted_at' => Carbon::now()]);
            //Delete previous bill dat6a
            Bill::where('delivery_id', $id)->delete();

            $model = FabricDelivery::findOrFail($id);
            $model->delete();
            return redirect()->route('fabric_delivery.prod.index')
                            ->with('success','Fabric Delivery deleted successfully');
        }
    }

    public function gatePassFabricDeliveryProduction($id){
        //dd($settings->address);
        $dalivery = FabricDelivery::find($id);
        $delivery_details = DB::table('fabric_delivery_details')
                          ->join('yarn_knitting_details','fabric_delivery_details.yarn_knitting_details_id','=','yarn_knitting_details.id')
                          ->whereNull('fabric_delivery_details.deleted_at')
                          ->where('fab_delivery_id',$id)
                          ->get();
        return view('fabric::fabric_delivery_production.gate_pass',compact('dalivery','delivery_details'));
    }

    public function deliveryChallanFabricDeliveryProduction($id){
        $dalivery = FabricDelivery::find($id);
        $delivery_details = DB::table('fabric_delivery_details')
                          ->join('yarn_knitting_details','fabric_delivery_details.yarn_knitting_details_id','=','yarn_knitting_details.id')
                          ->where('fab_delivery_id',$id)
                          ->whereNull('fabric_delivery_details.deleted_at')
                          ->get();
        return view('fabric::fabric_delivery_production.challan',compact('dalivery','delivery_details'));
    }

    public function billFabricDeliveryProduction($id){
        $dalivery = FabricDelivery::find($id);
        $delivery_details = DB::table('fabric_delivery_details')
        ->join('yarn_knitting_details', 'fabric_delivery_details.yarn_knitting_details_id', '=', 'yarn_knitting_details.id')
        ->where('fab_delivery_id', $id)
        ->whereNull('fabric_delivery_details.deleted_at')
        ->get();
        return view('fabric::fabric_delivery_production.bill', compact('dalivery', 'delivery_details'));
    }



    public function getKnittingDetails(Request $request)
    {
        $production = KnittingProductionDetail::where('knitting_id', $request->id)->sum('prod_qty');
        $delivery = KnittingProductionDetail::where('knitting_id', $request->id)->sum('delivery_quantity');

        $available = $production - $delivery;
        $knittingData = DB::table('yarn_knitting_program')->where('id', $request->id)->first();
        return response()->json([
            'available'          => $available,
            'stl_no'          => $knittingData->stl_order_no,
            'buyer_name'          => $knittingData->buyer_name,
            'rate'          => $knittingData->rate
        ]);
    }

    public function getPartyKnittingInfo(Request $request){
        //$knitting_programs = KnittingProgram::where('party_id',$request->id)->get();
        $knitting_programs = YarnKnittingDetails::where('party_id',$request->id)->get();
        return response()->json([
            'knittingInfo'          => $knitting_programs
        ]);
    }

    public function getYarnKnittingDetails(Request $request){

        $knitting_programs = YarnKnittingDetails::whereIn('id',$request->id)
                            ->get();
        $collectProducttion = [];
        $collectProducedRoll = [];
        $collectDeliveredRoll = [];
        $collectDelivery = [];
        foreach($request->id as $key=>$id){

             $production = KnittingProductionDetail::where('yarn_knitting_details_id',$id)->sum('quantity');

             $produced_roll = KnittingProductionDetail::where('yarn_knitting_details_id',$id)->sum('roll');
             $deliverd_roll =  DB::table('fabric_delivery_details')->whereNull('deleted_at')->where('yarn_knitting_details_id',$id)->sum('roll');
             $delivery = DB::table('fabric_delivery_details')->whereNull('deleted_at')->where('yarn_knitting_details_id',$id)->sum('quantity');
             array_push($collectProducttion,$production);
             array_push($collectProducedRoll,$produced_roll);
             array_push($collectDeliveredRoll,$deliverd_roll);
             array_push($collectDelivery,$delivery);
        }
        return response()->json([
            'knittingInfo'          => $knitting_programs,
            'productionInfo'        => $collectProducttion,
            'producedRollInfo'      => $collectProducedRoll,
            'deliverdRollInfo'      => $collectDeliveredRoll,
            'deliveryInfo'          => $collectDelivery
        ]);
    }
}
