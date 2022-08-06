<?php

namespace Modules\Yarn\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\Yarn\Entities\Stock;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $parties = Party::all();
        $total_party=count($parties);
        return view('yarn::party.index', compact('parties','total_party'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $party = Party::latest()->first();
        if(!empty($party)){
            $trim=trim($party->stl_no,"STL-");
            $stl_no=$trim + 1;
            $new_stl_no="STL-".$stl_no;
        }else{
            $new_stl_no="STL-"."01";
        }

        return view('yarn::party.create', compact('new_stl_no'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|digits:11|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'stl_no' => 'required|unique:yarn_parties'
        ]);

        if($validated){
            Party::create($request->all());

        }

        return redirect()->route('party.index')
                        ->with('success','Party created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $party = Party::find($id);
        return view('yarn::party.show', compact('party'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $party = Party::find($id);
        return view('yarn::party.edit', compact('party'));
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
            'name' => 'required',
            'phone' => 'required|digits:11|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'stl_no' => 'required|unique:yarn_parties,stl_no,'.$id
        ]);

        if($validated){
            $input = $request->all();
            $model = Party::where('id',$id)->first();
            $model->update($input);
        }

        return redirect()->route('party.index')
                        ->with('success','Party updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $dependency = ReceiveYarn::where('party_id', $id)->get();
        if(count($dependency) > 0){
            return redirect()->back()
                            ->with('errors','This data is used as next reference.');
        }else{
            $model = Party::findOrFail($id);
            $model->delete();
            return redirect()->route('party.index')
                            ->with('success','Party deleted successfully');
        }
    }

    public function getPartyInfo(Request $request){
        $recYarn = ReceiveYarn::where('stock','>','0')->where('party_id', $request->id)->pluck('chalan', 'id')->toArray();

        return response()->json([
            'recYarn'          => array_unique($recYarn)
        ]);

    }

    public function getPartyInfoEdit(Request $request){
        $recYarn = ReceiveYarn::where('id', $request->rec_id)->pluck('chalan', 'id');
        return response()->json([
            'recYarn'          => $recYarn
        ]);

    }

    public function getRecYarnInfo(Request $request){
        if(!empty($request->id)){
            $recYarn = [];

            foreach($request->id as $key=>$clallan_id){
                $stock = Stock::with('receiveYarn')->where('receive_id', $clallan_id)->first();
                $stock_in = Stock::where('receive_id', $clallan_id)->sum('stock_in');
                $stock_out = Stock::where('receive_id', $clallan_id)->sum('stock_out');
                $item['id']=$stock->receiveYarn->id;
                $item['gate_pass']=$stock->receiveYarn->gate_pass;
                $item['yarn_brand']=$stock->receiveYarn->brand;
                $item['yarn_count']=$stock->receiveYarn->count;
                $item['yarn_lot']=$stock->receiveYarn->lot;
                $item['yarn_receiving']=$stock->receiveYarn->quantity;
                // $item['current_yarn_stock']=$stock->stock_in;
                $item['yarn_receiving_roll']=$stock->receiveYarn->roll;
                $item['current_yarn_stock']=  $stock_in - $stock_out;
                array_push($recYarn, $item);
            }
        }else{
            $recYarn = '';
        }
        return response()->json([
            'recYarn'          => $recYarn
        ]);

    }

    public function getRecYarnInfoEdit(Request $request){
        $recYarn = ReceiveYarn::where('id', $request->id)->first();
        return response()->json([
            'gate_pass'         => $recYarn->gate_pass,
            'brand'             => $recYarn->brand,
            'count'             => $recYarn->count,
            'lot'               => $recYarn->lot,
            'quantity'          => $recYarn->quantity,
        ]);

    }
}
