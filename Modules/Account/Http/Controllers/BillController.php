<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bill;
use Modules\Yarn\Entities\Party;
use Modules\Fabric\Entities\FabricDelivery;
use Modules\Account\Entities\Revenue;
use DB;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $bills = Bill::where('is_paid',1)->latest()->get();
        return view('account::bill.index', compact('bills', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::pluck('name', 'id');
        $deliveries = FabricDelivery::pluck('chalan', 'id');

        // Generate bill no
        $bill = Bill::latest()->first();
        if(isset($bill->bill_no) && $bill->bill_no > 0){
            $bill_no = $bill->bill_no + 1;
        }else{
            $bill_no = 001;
        }
        return view('account::bill.create', compact('parties', 'deliveries', 'bill_no'));
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
            'bill_no' => 'required',
            'money_rec_no' => 'required',
            'payment_type' => 'required',
            'received_amount' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            $input['is_paid']=1;
            $input['created_by']=Auth::id();
            $bill = Bill::create($input);

            // Create Revenue according to the bill
            $revenueInput = [
                'date' => $request->date,
                'bill_id' => $bill->id,
                'party_id' => $request->party_id,
                'type' => $request->payment_type,
                'amount' => $request->received_amount
            ];
            Revenue::create($revenueInput);
        }

        return redirect()->route('bill.index')
                        ->with('success','Bill created successfully');
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
        $deliveries = FabricDelivery::pluck('chalan', 'id');
        $data = Bill::findOrFail($id);

        return view('account::bill.edit', compact('data', 'parties', 'deliveries'));
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
            'bill_no' => 'required',
            'money_rec_no' => 'required',
            'payment_type' => 'required',
            'amount' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            $model = Bill::where('id',$id)->first();
            $model->update($input);

            // Update Revenue according to the bill
            $revenueInput = [
                'date' => $request->date,
                'bill_id' => $id,
                'party_id' => $request->party_id,
                'type' => $request->payment_type,
                'amount' => $request->amount
            ];
            $revenueModel = Revenue::where('bill_id',$id)->first();
            if(!empty($revenueModel)){
                $revenueModel->update($revenueInput);
            }

        }

        return redirect()->route('bill.index')
                        ->with('success','Bill Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Delete previous revenue record
        Revenue::where('bill_id', $id)->delete();

        $model = Bill::where('id',$id)->first();
        $model->delete();
        return redirect()->route('bill.index')
                        ->with('success','Bill deleted successfully');
    }

    public function getBillAmount(Request $request)
    {
        $totalBill = FabricDelivery::where('party_id', $request->party_id)->sum('bill');
        $paidAmount = Bill::where('party_id', $request->party_id)->sum('received_amount');
        $payable = ($totalBill - $paidAmount);
        return response()->json([
            'totalBill'  => $totalBill,
            'paidAmount'  => $paidAmount,
            'payable'  => $payable
        ]);
    }


    // Bill Ledger functions

    public function getBillLedger(Request $request)
    {
        $parties = Party::all()->pluck('name', 'id');
        $bills = $this->__filter($request)->paginate(10);
        // $bills=Bill::with('party')->latest()->get()->groupBy('party_id');
        // dd($bills);
        return view('account::bill.bill_ledger', compact('bills', 'parties'));
    }

    public function getBillLedgerDetails(Request $request, $id)
    {
        $bills = Bill::where('party_id', $id)->get();
        $party_id=$id;
        return view('account::bill.bill_ledger_details', compact('bills','party_id'));
    }

    private function __filter($request)
    {
        $query = array();
        if ($request->party_id != null) {
            $query['party_id'] = $request->party_id;
        }
        $billQuery  = Bill::where($query)->select('party_id', DB::raw('sum(amount) as amount'), DB::raw('sum(received_amount) as received_amount'))
                    ->groupBy('party_id');

        $bill = $billQuery->with(['party']);
        return $bill;
    }

    public function dueBillCreate()
    {
        $parties = Party::pluck('name', 'id');
        return view('account::bill.due-bill-create', compact('parties'));
    }

    public function dueBillStore(Request $request)
    {

        $validated = $request->validate([
            'date' => 'required',
            'party_id' => 'required',
            'amount' => 'required'
        ]);

        if($validated){
            $input = $request->all();
            $bill = Bill::create($input);
        }

        return redirect()->route('bill.index')
                        ->with('success','Bill created successfully');
    }

    public function dueBillIndex()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $bills = Bill::where('is_paid',0)->latest()->get();
        return view('account::bill.due-index', compact('bills', 'user_role'));
    }

}
