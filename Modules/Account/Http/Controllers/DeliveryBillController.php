<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Party;
use Modules\Fabric\Entities\FabricDelivery;
use Modules\Account\Entities\Bill;
use Auth;
use DB;

class DeliveryBillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $delivery_bills = DB::table('delivery_bills')
                        ->join('yarn_parties','delivery_bills.party_id','=','yarn_parties.id')
                        ->select('delivery_bills.*','yarn_parties.name')
                        ->orderBy('id','DESC')->get();
        return view('account::delivery-bill.index',compact('delivery_bills', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //$parties = Party::pluck('name', 'id');
        $bill_number = DB::table('delivery_bills')->count();
        $parties = Party::latest()->get();
        return view('account::delivery-bill.create',compact('parties','bill_number'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required',
            'bill_number' => 'required'
        ]);

        if($validated){
            DB::beginTransaction();

            try {
                $auth_id = Auth::user()->id;
                $delivery_bill = DB::table('delivery_bills')->insertGetId([
                    'date' => $request->date,
                    'bill_number' => $request->bill_number,
                    'party_id' => $request->party_id,
                    'created_by' => $auth_id,
                ]);
                foreach($request->fab_delivery_id as $key => $id)
                {
                    if($id != null && $id > 0)
                    {
                        DB::table('delivery_bill_details')->insert([
                            'delivery_bill_id' => $delivery_bill,
                            'fab_delivery_id' => $id,
                            'note' => $request->note[$key],
                            'created_by' => $auth_id,
                        ]);
                    }
                }

                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return redirect()->route('delivery-bill.index')
                        ->with('success','error');
            }
        }
        return redirect()->route('delivery-bill.index')
                        ->with('success','Delivery Bill updated successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $delivery_bill = DB::table('delivery_bills')->where('delivery_bills.id',$id)
                        ->join('yarn_parties','delivery_bills.party_id','=','yarn_parties.id')
                        ->select('delivery_bills.*','yarn_parties.name','yarn_parties.address')
                        ->first();
        $bill_details = DB::table('delivery_bill_details')->where('delivery_bill_details.delivery_bill_id',$id)
                       ->join('fabric_deliveries','delivery_bill_details.fab_delivery_id','=','fabric_deliveries.id')
                       ->join('fabric_delivery_details','fabric_delivery_details.fab_delivery_id','=','fabric_deliveries.id')
                       ->join('yarn_knitting_details','yarn_knitting_details.id','=','fabric_delivery_details.yarn_knitting_details_id')
                       ->get();
        //dd($bill_details);
        return view('account::delivery-bill.show',compact('delivery_bill','bill_details'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = DB::table('delivery_bills')->where('id',$id)->first();
        $fab_delivery_details = DB::table('delivery_bill_details')
                              ->where('delivery_bill_id',$id)
                              ->join('fabric_delivery_details','delivery_bill_details.fab_delivery_id','=','fabric_delivery_details.fab_delivery_id')
                              ->select('delivery_bill_details.*','fabric_delivery_details.amount','fabric_delivery_details.rate','fabric_delivery_details.quantity','fabric_delivery_details.knitting_id')
                              ->get()->toArray();

        $collectChallan = [];
        $collectPartyorder = [];
        $collectFabtype = [];
        foreach($fab_delivery_details as $key=>$id){
            $fabricDelivery = FabricDelivery::where('id',$id->fab_delivery_id)->select('id','chalan')->first();
            $order_number = DB::table('yarn_knitting_program')->where('id',$id->knitting_id)->select('id','party_order_no')->first();
            $fab_type = DB::table('yarn_knitting_details')->where('knitting_id',$id->knitting_id)->where('party_id',$data->party_id)->select('id','fabric_type')->first();
            array_push($collectChallan,$fabricDelivery);
            array_push($collectPartyorder,$order_number);
            array_push($collectFabtype,$fab_type);
        }

        $parties = Party::latest()->get();
        return view('account::delivery-bill.edit',compact('parties','data','collectChallan','fab_delivery_details','collectPartyorder','collectFabtype'));
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
            'bill_number' => 'required'
        ]);
        if($validated){
            DB::beginTransaction();

            try {
                $auth_id = Auth::user()->id;

                $delivery_bill = DB::table('delivery_bills')->where('id',$id)->update([
                    'date' => $request->date,
                    'bill_number' => $request->bill_number,
                    'party_id' => $request->party_id,
                    'updated_by' => $auth_id,
                ]);

                //delete previous details data
                DB::table('delivery_bill_details')->where('delivery_bill_id',$id)->delete();

                foreach($request->fab_delivery_id as $key => $delivery_id)
                {
                    if($delivery_id != null && $delivery_id > 0)
                    {
                        DB::table('delivery_bill_details')->insert([
                            'delivery_bill_id' => $id,
                            'fab_delivery_id' => $delivery_id,
                            'note' => $request->note[$key],
                            'created_by' => $auth_id,
                            'updated_by' => $auth_id,
                        ]);
                    }
                }

                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return redirect()->route('delivery-bill.index')
                        ->with('success','error');
            }
        }
        return redirect()->route('delivery-bill.index')
                        ->with('success','Delivery Bill updated successfully');
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

    public function getDeliveryChallanInfo(Request $request)
    {
        $fabricDelivery = FabricDelivery::where('party_id', $request->id)->get();
        return response()->json([
            'fabricDelivery'          => $fabricDelivery
        ]);
    }

    // public function getChallanDetails(Request $request)
    // {
    //     $deliveryChallan = FabricDelivery::where('party_id', $request->id)->where('chalan', $request->chalan)->get();
    //     return response()->json([
    //         'deliveryChallan'          => $deliveryChallan
    //     ]);
    // }
    public function getChallanDetails(Request $request)
    {

        $bill_details = Bill::whereIn('delivery_id',$request->challan)
                     ->where('party_id',$request->id)
                     ->where('is_paid',0)
                     ->join('fabric_delivery_details','bills.delivery_id','=','fabric_delivery_details.fab_delivery_id')
                     ->get();
        $collectPartyorder = [];
        $collectFabtype = [];
        foreach($bill_details as $key =>$bill){
                $order_number = DB::table('yarn_knitting_program')->where('id',$bill->knitting_id)->select('id','party_order_no')->first();
                $fab_type = DB::table('yarn_knitting_details')->where('knitting_id',$bill->knitting_id)->where('party_id',$request->id)->select('id','fabric_type')->first();
                array_push($collectPartyorder,$order_number);
                array_push($collectFabtype,$fab_type);
        }
        //return $collectPartyorder;
        //return $bill_details;
        $html = view('account::delivery-bill.delivery_details',compact('bill_details','collectPartyorder','collectFabtype'))->render();
        return response()->json(compact('html'));
        //return $request->all();

        // $collectBill = [];
        // foreach($request->challan as $key=>$challan){
        //     $bill = DB::table('bills')
        //         ->where('bills.is_paid',0)
        //         ->where('bills.party_id',$request->id)
        //         ->where('bills.delivery_id',$challan[$key])
        //         ->join('fabric_delivery_details','bills.delivery_id','=','fabric_delivery_details.fab_delivery_id')
        //         ->join('yarn_knitting_details','fabric_delivery_details.yarn_knitting_details_id','=','yarn_knitting_details.id')
        //         ->join('yarn_knitting_program','yarn_knitting_details.knitting_id','=','yarn_knitting_program.id')
        //         ->select('bills.*','fabric_delivery_details.quantity','fabric_delivery_details.rate','fabric_delivery_details.amount','yarn_knitting_program.party_order_no','yarn_knitting_details.fabric_type')
        //         ->get();
        //     array_push($collectBill,$bill);
        // }


        // return response()->json([
        //     'bill'  => $bill_detail,
        // ]);
    }
}
