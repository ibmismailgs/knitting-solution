<?php

namespace Modules\Yarn\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\KnittingProgram;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\Stock;
use Modules\Yarn\Entities\ReturnYarn;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\Fabric\Entities\Production;
use Illuminate\Support\Facades\Auth;
use DB;

class KnittingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $knittingData = KnittingProgram::latest()->get();
        return view('yarn::knitting.index', compact('knittingData', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();

        $data = YarnKnittingDetails::orderBy('id', 'desc')->first();
        if(isset($data->stl_order_no)){
            $stlNo = explode('_', $data->stl_order_no);
            $stlNo = $stlNo[1]+1;
            $stlNo = "stl_".$stlNo;
        }else{
            $date = date("Ymd");
            $stlNo = $date."001";
            $stlNo = "stl_".$stlNo;
        }

        return view('yarn::knitting.create', compact('parties', 'stlNo'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'date' => 'required',
            'party_order_no' => 'required',
            'stl_order_no' => 'required',
            'party_id' => 'required',
            'receive_id' => 'required',
            'knitting_qty' => 'required|numeric',
            'rate' => 'required',
            'buyer_name' => 'required',
            'mc_dia' => 'required',
            'f_dia' => 'required',
            'sl' => 'required',
            'colour' => 'required',
            'fabric_type' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            // $knitting = KnittingProgram::create($input);
            $knitting = KnittingProgram::create([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'party_order_no' => $request->party_order_no,
                'note' => $request->note,
            ]);

            $yarnKnittingDetails = YarnKnittingDetails::create([
                'knitting_id' => $knitting->id,
                'date' => $request->date,
                'stl_order_no' => $request->stl_order_no,
                'party_id' => $request->party_id,
                'receive_id' => $request->receive_id,
                // 'party_order_no' => $request->party_order_no,
                'knitting_qty' => $request->knitting_qty,
                'buyer_name' => $request->buyer_name,
                'brand' => $request->brand,
                'count' => $request->count,
                'lot' => $request->lot,
                'mc_dia' => $request->mc_dia,
                'f_dia' => $request->f_dia,
                'f_gsm' => $request->f_gsm,
                'sl' => $request->sl,
                'colour' => $request->colour,
                'fabric_type' => $request->fabric_type,
                'rate' => $request->rate,
                'note' => $request->note,
            ]);
            // Stock entry.....
            $stockData = [
                'party_id' => $request->party_id,
                'receive_id' => $request->receive_id,
                'knitting_id' => $knitting->id,
                'knitting_details_id' => $yarnKnittingDetails->id,
                'stock_out' => $request->knitting_qty
            ];
            // Store stock data...
            Stock::create($stockData);
        }

        return redirect()->route('knitting.index')
                        ->with('success','Knitting created successfully');
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
        $data = KnittingProgram::where('id', $id)->first();
        // $knitting_details = DB::table('yarn_knitting_details')->where('knitting_id', $data->id)->get();
        $knitting_details = YarnKnittingDetails::where('knitting_id', $data->id)->get();

        return view('yarn::knitting.show', compact('data', 'knitting_details', 'user_role'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = KnittingProgram::where('id', $id)->first();
        $parties = Party::all();

        return view('yarn::knitting.edit', compact('data', 'parties'));
    }

    public function editKnittingDetails($id)
    {
        $knitting_details = YarnKnittingDetails::findOrFail($id);
        $parties = Party::all();

        return view('yarn::knitting.details_edit', compact('knitting_details', 'parties'));
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
            'buyer_name' => 'required',
            'mc_dia' => 'required',
            'f_dia' => 'required',
            'sl' => 'required',
            'colour' => 'required',
            'fabric_type' => 'required'
        ]);

        // return $request->all();
        $validated = $request->validate([
            'date' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            $model = KnittingProgram::where('id',$id)->first();
            //Update knitting program
            $model->update($input);
        }

        return redirect()->route('knitting.index')
                        ->with('success','Knitting Updated successfully');
    }

    public function updateKnittingDetails(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required',
            'rate' => 'required',
            'party_id' => 'required',
            // 'receive_id' => 'required',
            'knitting_qty' => 'required',
        ]);
        // Knitting details Update
        $yarnKnittingDetails = YarnKnittingDetails::where('id', $id)->first();
        if($request->receive_id=='null'){
            $receive_id=$yarnKnittingDetails->receive_id;
        }else{
            $receive_id=$request->receive_id;
        }
        $yarnKnittingDetails->update([
            'date' => $request->date,
            'receive_id' => $receive_id,
            'knitting_qty' => $request->knitting_qty,
            'buyer_name' => $request->buyer_name,
            'brand' => $request->brand,
            'count' => $request->count,
            'lot' => $request->lot,
            'mc_dia' => $request->mc_dia,
            'f_dia' => $request->f_dia,
            'f_gsm' => $request->f_gsm,
            'sl' => $request->sl,
            'colour' => $request->colour,
            'fabric_type' => $request->fabric_type,
            'rate' => $request->rate,
            'note' => $request->note,
        ]);

        // Delete previous stock
        Stock::where('knitting_id', $request->knitting_id)->where('knitting_details_id', $id)->delete();
        // Stock entry.....
        $stockData = [
            'party_id' => $request->party_id,
            'receive_id' => $receive_id,
            'knitting_id' => $request->knitting_id,
            'knitting_details_id' => $id,
            'stock_out' => $request->knitting_qty
        ];
        // Store stock data...
        Stock::create($stockData);

        return redirect()->route('knitting.show', $request->knitting_id)
                        ->with('success','Knitting Details Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $dependency = Production::where('knitting_id', $id)->get();
        if(count($dependency) > 0){
            return redirect()->back()
                            ->with('errors','This data is used as next reference.');
        }else{
            // Delete previous stock
            Stock::where('knitting_id', $id)->delete();

            $model = KnittingProgram::findOrFail($id);

            //Delete previous knitting details before delete
            $yarnKnittingDetails = YarnKnittingDetails::where('knitting_id', $model->id)->where('party_id', $model->party_id)
            ->get();
            // DB::table('yarn_knitting_details')->where('knitting_id', $model->id)->where('party_id', $model->party_id)
            // ->where('receive_id', $model->receive_id)->delete();
            foreach ($yarnKnittingDetails as $key => $value) {
                $value->delete();
            }
            $model->delete();
            return redirect()->back()
                            ->with('success','Knitting deleted successfully');
        }
    }

    public function deleteKnittingDetails($id)
    {
        // $knitting = DB::table('yarn_knitting_details')->where('id', $id)->first();
        $knitting = YarnKnittingDetails::where('id', $id)->first();
        $knitting_id = $knitting->knitting_id;
// dd($knitting);
        // Delete previous stock
        Stock::where('knitting_id', $knitting->knitting_id)->where('knitting_details_id', $id)->delete();
        $knitting->delete();

        return redirect()->route('knitting.show', $knitting_id)
                        ->with('success','Knitting Details Deleted successfully');
    }

    public function addMoreKnitting($id)
    {
        $data = YarnKnittingDetails::orderBy('id', 'desc')->first();
        if(isset($data->stl_order_no)){
            $stlNo = explode('_', $data->stl_order_no);
            $stlNo = $stlNo[1]+1;
            $stlNo = "STL_".$stlNo;
        }else{
            $date = date("Ymd");
            $stlNo = $date."001";
            $stlNo = "STL_".$stlNo;
        }
        $knitting_program = KnittingProgram::where('id', $id)->first();
        // $data = KnittingProgram::where('id', $id)->first();
        $parties = Party::all();
        return view('yarn::knitting.add_more', compact('knitting_program','stlNo','parties'));
    }


    public function submitMoreKnittingQty(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required',
            'rate' => 'required',
            'party_id' => 'required|numeric',
            'receive_id' => 'required|numeric',
            'knitting_qty' => 'required',
            'stl_order_no' => 'required',
        ]);

            DB::beginTransaction();

            try {
                $details = YarnKnittingDetails::create([
                    'knitting_id' => $request->knitting_id,
                    'date' => $request->date,
                    'stl_order_no' => $request->stl_order_no,
                    'party_id' => $request->party_id,
                    'receive_id' => $request->receive_id,
                    // 'party_order_no' => $request->party_order_no,
                    'knitting_qty' => $request->knitting_qty,
                    'buyer_name' => $request->buyer_name,
                    'brand' => $request->brand,
                    'count' => $request->count,
                    'lot' => $request->lot,
                    'mc_dia' => $request->mc_dia,
                    'f_dia' => $request->f_dia,
                    'f_gsm' => $request->f_gsm,
                    'sl' => $request->sl,
                    'colour' => $request->colour,
                    'fabric_type' => $request->fabric_type,
                    'rate' => $request->rate,
                    'note' => $request->note,
                ]);

                // Stock entry.....
                $stockData = [
                    'party_id' => $request->party_id,
                    'receive_id' => $request->receive_id,
                    'knitting_id' => $request->knitting_id,
                    'knitting_details_id' => $details->id,
                    'stock_out' => $request->knitting_qty
                ];
                // Store stock data...
                Stock::create($stockData);

                DB::commit();
                // all good
                return redirect()->route('knitting.show', $id)
                            ->with('success','Knitting Details Updated successfully');
            } catch (\Exception $e) {
                // dd($e);
                DB::rollback();
                // something went wrong
                return redirect()->back()
                            ->with('errors','Something went wrong!');
            }
    }

    public function getPartyYarnReceiveInfo(Request $request)
    {
        $recYarn_name = ReceiveYarn::where('party_id', $request->id)->get();
        return response()->json([
            'recYarn_name'          => $recYarn_name
        ]);
    }

    public function getStockInfo(Request $request)
    {
        $stock_in = Stock::where('party_id', $request->id)->where('receive_id', $request->rec_id)->sum('stock_in');
        $stock_out = Stock::where('party_id', $request->id)->where('receive_id', $request->rec_id)->sum('stock_out');
        $stock = $stock_in - $stock_out;

        $rec_info = ReceiveYarn::where('party_id', $request->id)->where('id', $request->rec_id)->first();

        $lot = $rec_info->lot;
        $count = $rec_info->count;
        $brand = $rec_info->brand;

        return response()->json([
            'stock'          => $stock,
            'brand'          => $brand,
            'count'          => $count,
            'lot'          => $lot
        ]);
    }
}
