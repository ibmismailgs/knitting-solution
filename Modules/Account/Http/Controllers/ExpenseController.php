<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bill;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Expense;
use Modules\Account\Entities\Revenue;
use Illuminate\Contracts\Support\Renderable;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $expenses = Expense::all();

        return view('account::expense.index', compact('expenses', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::pluck('name', 'id');

        return view('account::expense.create', compact('parties'));
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
            Expense::create($input);
        }

        return redirect()->route('expense.index')
                        ->with('success','Expense created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('account::expense.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $parties = Party::pluck('name', 'id');
        $data = Expense::findOrFail($id);

        return view('account::expense.edit', compact('data', 'parties'));
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
            $model = Expense::where('id',$id)->first();
            $model->update($input);
        }

        return redirect()->route('expense.index')
                        ->with('success','Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $model = Expense::where('id',$id)->first();
        $model->delete();

        return redirect()->route('expense.index')
                        ->with('success','Expense deleted successfully');
    }
}
