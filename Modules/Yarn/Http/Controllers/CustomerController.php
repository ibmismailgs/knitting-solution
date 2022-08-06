<?php

namespace Modules\Yarn\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //Here customer= Employee
        $customers = Customer::all();
        return view('yarn::customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('yarn::customer.create');
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
            'phone' => 'required',
            'dob' => 'required'
        ]);
    
        if($validated){
            $input = $request->all();
            Customer::create($input);
        }
    
        return redirect()->route('customer.index')
                        ->with('success','Customer created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('yarn::customer.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('yarn::customer.edit', compact('customer'));
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
            'phone' => 'required',
            'dob' => 'required'
        ]);
    
        if($validated){
            $input = $request->all();
            $customer = Customer::where('id',$id)->first();

            $customer->update($input);
        }
    
        return redirect()->route('customer.index')
                        ->with('success','Customer Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $model = Customer::findOrFail($id);
        $model->delete();
        return redirect()->route('customer.index')
                        ->with('success','Customer deleted successfully');
    }
}
