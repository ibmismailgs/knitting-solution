<?php

namespace Modules\Yarn\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\Stock;
use Modules\Yarn\Entities\ReturnYarn;
use Modules\Yarn\Entities\ReceiveYarn;
use DB;
use Illuminate\Support\Facades\Auth;

class ReturnYarnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //$ret_yarn = ReturnYarn::OrderBy('id','DESC')->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $ret_yarn = ReturnYarn::with('party')->select([DB::raw("SUM(quantity) as total,ret_chalan,ret_gate_pass,date,party_id")])
                    ->groupBy('ret_chalan','ret_gate_pass','date','party_id')
                    ->orderBy('date','DESC')
                    ->get();
        //dd($ret_yarn);
        return view('yarn::return_yarn.index', compact('ret_yarn' , 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();
        $return_count = ReturnYarn::count();
        return view('yarn::return_yarn.create', compact('parties','return_count'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // if($request->validation == 0){
        //     return redirect()->back()
        //                 ->with('errors','Operation is not valid');
        // }
        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required',
            'stock_out' => 'required'
        ]);

        if($validated){
            $input = array();

            foreach($request->stock_out as $key => $value)
            {
                if($value != null && $value > 0)
                {
                    $input = $request->except(['chalan', 'rec_yarn_id', 'stock_out']);
                    $input['receive_id'] = $request->rec_yarn_id[$key];
                    $input['quantity'] = $value;
                    $input['roll'] = $request->roll[$key];
                    $retYarn = ReturnYarn::create($input);

                    //yarn_receive stock update
                    $yarn_receive = ReceiveYarn::where('id',$request->rec_yarn_id[$key])->first();
                    $final_stock = $yarn_receive->stock - $value;
                    $stockReceive = [
                        'stock' => $final_stock,
                    ];
                    ReceiveYarn::where('id',$request->rec_yarn_id[$key])->update($stockReceive);


                    // Stock entry.....
                    $stockData = [
                        'party_id' => $request->party_id,
                        'receive_id' => $request->rec_yarn_id[$key],
                        'return_id' => $retYarn->id,
                        'stock_out' => $value
                    ];
                    // Store stock data...
                    Stock::create($stockData);
                }
            }
        }
        return redirect()->route('return_yarn.index')
                        ->with('success','Return yarn created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $ret_yarn = ReturnYarn::where('ret_chalan',$id)->get();
        $receive_id = [];
        foreach($ret_yarn as $key=>$yern){
            array_push($receive_id,$yern->receive_id);
        }
        $ret_yarn_first = ReturnYarn::where('ret_chalan',$id)->first();
        $return_yarns = ReturnYarn::with('receiveYarn')->whereIn('receive_id',$receive_id)->where('ret_chalan',$id)->get();
        return view('yarn::return_yarn.show', compact('return_yarns','ret_yarn_first'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $ret_yarn = ReturnYarn::where('ret_chalan',$id)->get();
        $ret_yarn_first = ReturnYarn::where('ret_chalan',$id)->first();
        $receive_id = [];
        $total_stock = [];
        foreach($ret_yarn as $key=>$yern){
            array_push($receive_id,$yern->receive_id);
        }
        $challan = array_unique(ReceiveYarn::whereIn('id',$receive_id)->pluck('chalan')->toArray());

        foreach( $receive_id as  $yarn_receive_id ){
            $stock_in = Stock::where('receive_id', $yarn_receive_id)->sum('stock_in');
            $stock_out = Stock::where('receive_id', $yarn_receive_id)->sum('stock_out');
            $result = $stock_in- $stock_out;
            array_push($total_stock, $result);
        }

        $return_yarns = ReturnYarn::with('receiveYarn')->whereIn('receive_id',$receive_id)->where('ret_chalan',$id)->get();
        $parties = Party::all();
        return view('yarn::return_yarn.edit', compact('ret_yarn', 'parties','return_yarns','ret_yarn_first','return_yarns','challan', 'total_stock'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    // public function update(Request $request, $id)
    // {
    //     dd($request->all());
    //     $yern_return = ReturnYarn::where('ret_chalan',$id)->get();
    //     foreach($yern_return as $yern){
    //         //previous stock delete
    //         $stock = Stock::where('return_id',$yern->id)->first();
    //         $stock->delete();
    //         //previous return delete
    //         ReturnYarn::find($yern->id)->delete();
    //     }

    //     $validated = $request->validate([
    //         'date' => 'required',
    //         'party_id' => 'required',
    //         'quantity' => 'required'
    //     ]);

    //     dd($request->all());

    //     if($validated){
    //         $input = array();
    //         foreach($request->stock_out as $key => $value)
    //         {
    //             if($value != null && $value > 0)
    //             {
    //                 $input = $request->except(['rec_yarn_id', 'stock_out']);
    //                 // $input['receive_id'] = $request->rec_yarn_id[$key];
    //                 // $input['quantity'] = $value;
    //                 $returnYarn = [
    //                     'date' => $request->date,
    //                     'ret_chalan' => $request->ret_chalan,
    //                     'ret_gate_pass' => $request->ret_gate_pass,
    //                     'party_id' => $request->party_id,
    //                     'receive_id' => $request->rec_yarn_id[$key],
    //                     'quantity' => $value
    //                 ];
    //                 $retYarn = ReturnYarn::create($returnYarn);



    //                 dd($retYarn);
    //                 // Stock entry.....
    //                 $stockData = [
    //                     'party_id' => $request->party_id,
    //                     'receive_id' => $request->rec_yarn_id[$key],
    //                     'return_id' => $retYarn->id,
    //                     'stock_out' => $value
    //                 ];
    //                 // Store stock data...
    //                 Stock::create($stockData);
    //             }
    //         }

    //     }
    //     return redirect()->route('return_yarn.index')
    //                     ->with('success','Return yarn updated successfully');
    // }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Delete previous stock
        $yern_return = ReturnYarn::where('ret_chalan',$id)->get();
        foreach($yern_return as $yern){
            //previous stock delete
            $stock = Stock::where('return_id',$yern->id)->first();
            $stock->delete();
            //previous return delete
            ReturnYarn::find($yern->id)->delete();
        }
        return redirect()->back()
                        ->with('success','Return yarn deleted successfully');
    }

    public function storeYearn(Request $request){
        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required'
        ]);
        $yern_return = ReturnYarn::where('ret_chalan',$request->ret_chalan)->get();

        foreach($yern_return as $yern){
            //previous stock delete
            $stock = Stock::where('return_id',$yern->id)->first();
            $stock->delete();
            //previous return delete
            ReturnYarn::find($yern->id)->delete();
            //$return->delete();

        }
        if($validated){
            foreach($request->stock_out as $key => $value)
            {
                if($value != null && $value > 0)
                {
                    $returnYarn = [
                        'date' => $request->date,
                        'ret_chalan' => $request->ret_chalan,
                        'ret_gate_pass' => $request->ret_gate_pass,
                        'party_id' => $request->party_id,
                        'receive_id' => $request->rec_yarn_id[$key],
                        'quantity' => $value,
                        'roll' => $request->roll[$key],
                        'driver' => $request->driver,
                        'truck_number' => $request->truck_number
                    ];
                    $retYarn = ReturnYarn::create($returnYarn);

                    //yarn_receive stock update
                    $yarn_receive = ReceiveYarn::where('id',$request->rec_yarn_id[$key])->first();
                    $balance = $request->previous_stock_out[$key] - $value;
                    $final_stock = $yarn_receive->stock + $balance;
                    $stockReceive = [
                        'stock' => $final_stock,
                    ];
                    ReceiveYarn::where('id',$request->rec_yarn_id[$key])->update($stockReceive);

                    // Stock entry.....
                    $stockData = [
                        'party_id' => $request->party_id,
                        'receive_id' => $request->rec_yarn_id[$key],
                        'return_id' => $retYarn->id,
                        'stock_out' => $value
                    ];
                    // Store stock data...
                    Stock::create($stockData);
                }
            }
        }

        return redirect()->route('return_yarn.index')
                        ->with('success','Return yarn updated successfully');
    }

    public function deliveryChallanReturnYarn($id){
        $ret_yarn = ReturnYarn::where('ret_chalan',$id)->get();
        $receive_id = [];
        foreach($ret_yarn as $key=>$yern){
            array_push($receive_id,$yern->receive_id);
        }
        $ret_yarn_first = ReturnYarn::where('ret_chalan',$id)->first();
        $return_yarns = ReturnYarn::with('receiveYarn')->whereIn('receive_id',$receive_id)->where('ret_chalan',$id)->get();
        //dd($return_yarns);
        return view('yarn::return_yarn.challan',compact('ret_yarn_first','return_yarns'));
    }

    public function gatePassReturnYarn($id){
        $ret_yarn = ReturnYarn::where('ret_chalan',$id)->get();
        $receive_id = [];
        foreach($ret_yarn as $key=>$yern){
            array_push($receive_id,$yern->receive_id);
        }
        $ret_yarn_first = ReturnYarn::where('ret_chalan',$id)->first();
        $return_yarns = ReturnYarn::with('receiveYarn')->whereIn('receive_id',$receive_id)->where('ret_chalan',$id)->get();
        return view('yarn::return_yarn.gate_pass',compact('ret_yarn_first','return_yarns'));
    }
}
