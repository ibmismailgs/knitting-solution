<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bill;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Revenue;
use Illuminate\Contracts\Support\Renderable;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $revenues = Revenue::all();
        return view('account::revenue.index', compact('revenues', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::pluck('name', 'id');

        return view('account::revenue.create', compact('parties'));
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
            'type' => 'required',
            'amount' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            Revenue::create($input);
        }

        return redirect()->route('revenue.index')
                        ->with('success','Revenue created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $parties = Party::pluck('name', 'id');
        $data = Revenue::findOrFail($id);
        return view('account::revenue.edit', compact('data', 'parties'));
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
            'type' => 'required',
            'amount' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            $model = Revenue::where('id',$id)->first();
            $model->update($input);
        }

        return redirect()->route('revenue.index')
                        ->with('success','Revenue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $model = Revenue::where('id',$id)->first();

        $bill = Bill::where('id', $model->bill_id)->first();

        if(isset($bill)){
            return redirect()->back()
                        ->with('errors','This data is used somewhere else!');
        }

        $model->delete();

        return redirect()->route('revenue.index')
                        ->with('success','Revenue deleted successfully');
    }
}
