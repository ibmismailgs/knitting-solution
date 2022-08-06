<?php

namespace Modules\Yarn\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\Stock;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Yarn\Entities\ReturnYarn;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\Yarn\Entities\ReceiveChallan;
use Illuminate\Contracts\Support\Renderable;
use Modules\Yarn\Entities\YarnKnittingDetails;

class ReceiveYarnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $rec_yarn = ReceiveChallan::latest()->get();
        return view('yarn::receive_yarn.index', compact('rec_yarn', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();
        return view('yarn::receive_yarn.create', compact('parties'));
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
            'brand' => 'required'
        ]);

        if($validated){
            $token = time().Str::random(5);
            foreach ($request->brand as $key => $value) {
                $input = [
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'chalan' => $request->chalan,
                    'gate_pass' => $request->gate_pass,
                    'note' => $request->note,
                    'brand' => $request->brand[$key],
                    'count' => $request->count[$key],
                    'lot' => $request->lot[$key],
                    'roll' => $request->roll[$key],
                    'quantity' => $request->quantity[$key],
                    'stock' => $request->quantity[$key],
                    'token'=> $token,
                ];
                $recYarn = ReceiveYarn::create($input);

                // Stock entry.....
                $stockData = [
                    'party_id' => $request->party_id,
                    'receive_id' => $recYarn->id,
                    'stock_in' => $request->quantity[$key]
                ];
                // Store stock data...
                Stock::create($stockData);
            }
            ReceiveChallan::create([
                'receive_id' => $recYarn->id,
                'party_id' =>$request->party_id,
                'chalan'=> $request->chalan,
                'gate_pass' => $request->gate_pass,
                'token'=> $token,
                'created_by' => Auth::id(),
            ]);

        }
        return redirect()->route('receive_yarn.index')
                        ->with('success','Receive yarn created successfully');
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
        $data = ReceiveChallan::find($id);
        $receiveYrans=ReceiveYarn::where('token',$data->token)->get();
        return view('yarn::receive_yarn.show', compact('data','receiveYrans', 'user_role'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $rec_yarn = ReceiveYarn::find($id);
        $parties = Party::all();
        return view('yarn::receive_yarn.edit', compact('rec_yarn', 'parties'));
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
            'brand' => 'required',
            'count' => 'required',
            'lot' => 'required',
            'quantity' => 'required'
        ]);

        $dependency = ReturnYarn::where('receive_id', $id)->get();
        $dependency_yarn = YarnKnittingDetails::where('receive_id', $id)->get();
        if ((count($dependency) > 0) || (count($dependency_yarn) > 0)) {
            return redirect()->back()
                ->with('errors', 'This data is used as next reference.');
        }else{

            $input = $request->all();
            $model = ReceiveYarn::where('id',$id)->first();
            $model->update($input);

            //Delete previous stock data
            Stock::where('receive_id', $id)->delete();
            // Stock entry.....
            $stockData = [
                'party_id' => $model->party_id,
                'receive_id' => $id,
                'stock_in' => $request->quantity
            ];
            // Store stock data...
            Stock::create($stockData);
        }

        return redirect()->route('receive_yarn.index')
                        ->with('success','Receive yarn created successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $dependency = ReturnYarn::where('receive_id', $id)->get();
        $dependency_yarn = YarnKnittingDetails::where('receive_id', $id)->get();
        if((count($dependency) > 0) || (count($dependency_yarn) > 0)){
            return redirect()->back()
                            ->with('errors','This data is used as next reference.');
        }else{
            //Delete previous stock data
            Stock::where('receive_id', $id)->delete();

            $model = ReceiveChallan::findOrFail($id);
            $yarnReceiveDetails = ReceiveYarn::all();
            foreach ($yarnReceiveDetails as $key => $value) {
                $value->delete();
            }
            $model->delete();
            return redirect()->back()
                ->with('success', 'Receive yarn deleted successfully');
        }

    }
    public function yarnReceiveDetailsDelete($id)
    {
        $receive_yarn_detail = ReceiveYarn::findOrFail($id);
        $receive_yarn_detail->delete();
        return redirect()->route('receive_yarn.show', $receive_yarn_detail)
            ->with('success', 'Knitting Details Deleted successfully');
    }
}
