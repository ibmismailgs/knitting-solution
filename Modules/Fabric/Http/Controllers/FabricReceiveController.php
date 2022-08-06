<?php

namespace Modules\Fabric\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Fabric\Entities\FabricReceive;
use Modules\Fabric\Entities\FabricDelivery;
use Illuminate\Contracts\Support\Renderable;

class FabricReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $fab_receives = FabricReceive::all();
        return view('fabric::fabric_receive.index', compact('fab_receives', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();
        return view('fabric::fabric_receive.create', compact('parties'));
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
            'party_id' => 'required',
            'chalan' => 'required',
            'gate_pass' => 'required'
        ]);

        if($validated){
            // Store fabric receive
            $input = [
                'date' => $request->date,
                'name' => $request->stl_no."_".$request->chalan."_".$request->order_no,
                'party_id' => $request->party_id,
                'chalan_no' => $request->chalan,
                'gate_pass_no' => $request->gate_pass,
                'order_no' => $request->order_no,
                'stl_no' => $request->stl_no,
                'buyer_name' => $request->buyer_name,
                'note' => $request->note
            ];
            $recFB = FabricReceive::create($input);

            $totalQty = 0;
            foreach ($request->quantity as $key => $value) {
                if($request->quantity[$key] > 0){
                    $totalQty += $request->quantity[$key];
                    // Store fabric receive details
                    DB::table('fabric_receive_details')->insert([
                        'fab_rec_id' => $recFB->id,
                        'count' => $request->count[$key],
                        'lot' => $request->lot[$key],
                        'roll' => $request->roll[$key],
                        'quantity' => $request->quantity[$key],
                        'stock' => $request->quantity[$key]
                    ]);
                }
            }

            // Update Fabric receive stocks....
            DB::table('fabric_stocks')->insert([
                'receive_id' => $recFB->id,
                'party_id' => $request->party_id,
                'stock_in' => $totalQty
            ]);

        }
        return redirect()->route('fabric_receive.index')
                        ->with('success','Fabric Receive created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $data = FabricReceive::find($id);
        $fab_rec_details = DB::table('fabric_receive_details')->whereNull('deleted_at')->where('fab_rec_id', $id)->get();

        return view('fabric::fabric_receive.show', compact('data', 'fab_rec_details', 'user_role'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = FabricReceive::find($id);
        $fab_details = DB::table('fabric_receive_details')->where('fab_rec_id', $id)->whereNull('deleted_at')->get();
        $parties = Party::all();
        return view('fabric::fabric_receive.edit', compact('parties', 'data', 'fab_details'));
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
            'chalan' => 'required',
            'gate_pass' => 'required'
        ]);

        if($validated){
            // Update fabric receive
            $input = [
                'date' => $request->date,
                'party_id' => $request->party_id,
                'chalan_no' => $request->chalan,
                'gate_pass_no' => $request->gate_pass,
                'order_no' => $request->order_no,
                'stl_no' => $request->stl_no,
                'buyer_name' => $request->buyer_name,
                'note' => $request->note
            ];

            $model = FabricReceive::where('id',$id)->first();
            $model->update($input);

            // Delete previous pivot data
            DB::table('fabric_receive_details')->where('fab_rec_id', $id)->delete();

            $totalQty = 0;
            foreach ($request->quantity as $key => $value) {
                if($request->quantity[$key] > 0){
                    $totalQty += $request->quantity[$key];
                    // Store fabric receive details
                    DB::table('fabric_receive_details')->insert([
                        'fab_rec_id' => $id,
                        'count' => $request->count[$key],
                        'lot' => $request->lot[$key],
                        'roll' => $request->roll[$key],
                        'quantity' => $request->quantity[$key]
                    ]);
                }
            }

            // Delete previous stock data
            DB::table('fabric_stocks')->where('receive_id', $id)->delete();

            // Update Fabric receive stocks....
            DB::table('fabric_stocks')->insert([
                'receive_id' => $id,
                'party_id' => $request->party_id,
                'stock_in' => $totalQty
            ]);

        }
        return redirect()->route('fabric_receive.index')
                        ->with('success','Fabric Receive updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $reference = FabricDelivery::where('receive_id', $id)->first();
        if(isset($reference)){
            return redirect()->back()->with('errors','This data is used somewhere else!');
        }else{
            // Delete previous pivot data
            DB::table('fabric_receive_details')->where('fab_rec_id', $id)->delete();

            // Delete previous stock data
            DB::table('fabric_stocks')->where('receive_id', $id)->delete();

            $model = FabricReceive::findOrFail($id);
            $model->delete();
            return redirect()->route('fabric_receive.index')
            ->with('success','Fabric Receive deleted successfully');
        }
    }

    public function deleteFabricReceiveDetails($id)
    {
        $fab_rec_id = DB::table('fabric_receive_details')->where('id', $id)->pluck('fab_rec_id');
        $fab_rec_id = $fab_rec_id[0];

        // Delete Fabric Receive Details data
        DB::table('fabric_receive_details')->where('id', $id)->delete();

        return redirect()->route('fabric_receive.show', $fab_rec_id)
        ->with('success','Fabric Receive details deleted successfully');
    }
}
