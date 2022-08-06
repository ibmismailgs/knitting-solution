<?php

namespace Modules\Fabric\Http\Controllers;

use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Modules\Yarn\Entities\Party;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Customer;
use Modules\Yarn\Entities\Employee;
use Illuminate\Support\Facades\Auth;
use Modules\Fabric\Entities\Production;
use Illuminate\Support\Facades\Validator;
use Modules\Yarn\Entities\KnittingProgram;
use Illuminate\Contracts\Support\Renderable;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $productions = Production::with('party','knittingprogram', 'knittingprogramDetails')
        ->whereNull('deleted_at')->latest()->get();
        return view('fabric::production.index', compact('productions', 'user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $parties = Party::all();
        $operators = Employee::all();
        $knitting_programs = KnittingProgram::all();
        return view('fabric::production.create', compact('parties', 'knitting_programs', 'operators'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'party_id' => 'required',
            'party_order_no' => 'required',
            'knitting_details_id' => 'required',
            'mc_dia' => 'required',
            'mc_no' => 'required',
            'order_qty' => 'required',
            'operator_name' => 'array|required',
            'shift' => 'array|required',
            'roll' => 'array|required',
            'quantity' => 'array|required',
            'rate' => 'array',
            'amount' => 'array',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $production = Production::create([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'knitting_id' => $request->party_order_no,
                'yarn_knitting_details_id' => $request->knitting_details_id,
                'mc_dia' => $request->mc_dia,
                'mc_no' => $request->mc_no,
                'order_qty' => $request->order_qty,
                'note' => $request->note,
            ]);
            foreach ($request->roll as $key => $id) {
                $details['production_id'] = $production->id;
                $details['party_id'] = $production->party_id;
                $details['knitting_id'] = $production->knitting_id;
                $details['yarn_knitting_details_id'] = $production->yarn_knitting_details_id;
                $details['employee_id'] = $request->operator_name[$key];
                $details['roll'] = $id;
                $details['shift'] = $request->shift[$key];
                $details['quantity'] = $request->quantity[$key];
                $details['rate'] = $request->rate[$key];
                $details['amount'] = $request->amount[$key];
                KnittingProductionDetail::insert($details);
            }
            return redirect()->route('production.index')
            ->with('success', 'Production successfully created.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $production = Production::find($id);
        $productiondetails = KnittingProductionDetail::where('production_id',$id)->get();

        $total_production = KnittingProductionDetail::where('production_id', $id)->select('knitting_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(roll) as roll'))
        ->groupBy('knitting_id')
        ->first();

        return view('fabric::production.view', compact('production', 'productiondetails', 'total_production'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $production = Production::find($id);
        $parties = Party::all();
        $operators = Employee::all();
        $knitting_programs = KnittingProgram::all();
        $knitting_details = YarnKnittingDetails::all();
        $productiondetails = KnittingProductionDetail::with('employee')->where('production_id', $id)
        ->get();
        return view('fabric::production.edit', compact('production', 'parties', 'knitting_programs', 'operators', 'productiondetails', 'knitting_details'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'party_id' => 'required',
            'party_order_no' => 'required',
            'knitting_details_id' => 'required',
            'mc_dia' => 'required',
            'mc_no' => 'required',
            'order_qty' => 'required',
            'operator_name' => 'array|required',
            'shift' => 'array|required',
            'roll' => 'array|required',
            'quantity' => 'array|required',
            'rate' => 'array',
            'amount' => 'array',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            $production = Production::findOrFail($id);
            $production->update([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'knitting_id' => $request->party_order_no,
                'yarn_knitting_details_id' => $request->knitting_details_id,
                'mc_dia' => $request->mc_dia,
                'mc_no' => $request->mc_no,
                'order_qty' => $request->order_qty,
                'note' => $request->note,
            ]);

            KnittingProductionDetail::where('production_id', $id)->delete();

            foreach ($request->roll as $key => $id) {
                $details['production_id'] = $production->id;
                $details['party_id'] = $production->party_id;
                $details['knitting_id'] = $production->knitting_id;
                $details['yarn_knitting_details_id'] = $production->yarn_knitting_details_id;
                $details['employee_id'] = $request->operator_name[$key];
                $details['roll'] = $id;
                $details['shift'] = $request->shift[$key];
                $details['quantity'] = $request->quantity[$key];
                $details['rate'] = $request->rate[$key];
                $details['amount'] = $request->amount[$key];
                KnittingProductionDetail::insert($details);
            }
            return redirect()->route('production.index')->with('success', 'Data updated successfully completed.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $production = DB::table('productions')
        ->where('id', $id)->update(['deleted_at' => Carbon::now()]);

        if ($production) {
            DB::table('knitting_production_details')->where('production_id', $id)->update(['deleted_at' => Carbon::now()]);
            return redirect()->route('production.index')
            ->with('success', 'Production deleted successfully');
        }
    }

    public function getKnittingProductionAmount(Request $request)
    {
        $yarnKnittingDetails = YarnKnittingDetails::where('id', $request->id)->first();
        $totalKnitQty = YarnKnittingDetails::where('id', $request->id)->sum('knitting_qty');
        $prodDone =  KnittingProductionDetail::where('yarn_knitting_details_id', $yarnKnittingDetails->id)->sum('quantity');
        $knittingProgram = KnittingProgram::where('id', $yarnKnittingDetails->knitting_id)->first();
        // $client=$knittingProgram->party->name;

        $available_for_production = $totalKnitQty - $prodDone;
        if ($available_for_production > 0) {
            return response()->json([
                'knitting_quantity'          => $yarnKnittingDetails->knitting_qty,
                'prodDone'          => $prodDone,
                'yarnKnittingDetails'          => $yarnKnittingDetails,
                'totalKnitQty'          => $totalKnitQty,
                'available_for_production'          => $available_for_production,
                // 'client'          => $client
            ]);
        } else {
            return response()->json([
                'available_for_production'          => 0,
            ]);
        }
    }
    //
    public function getKnittingProgram(Request $request){

        $knitting = KnittingProgram::where('party_id',$request->id)->get();
        $data = [];
        foreach ($knitting as $key => $value) {
                $item = [];
                $item['key'] = $value->id;
                $item['value'] = $value->party_order_no;
                array_push($data, $item);
        }
        return response()->json($data);

    }

    public function getKnittingProgramDetails(Request $request)
    {
        // $knitting = KnittingProgram::where('party_id',$request->id)->get();
        $yarnKnittingDetails = YarnKnittingDetails::where('knitting_id', $request->id)->get();
        $data = [];
        foreach ($yarnKnittingDetails as $key => $value) {
                $item = [];
                $item['key'] = $value->id;
                $item['value'] = $value->stl_order_no . '-' . $value->knitting_qty.'KG' ;
                array_push($data, $item);
        }
        return response()->json($data);
    }
    public function getDailyProductionReportGet(Request $request)
    {
        $date = date('Y-m-d');

        $page_title = "Production report of ".$date;

        $productions = Production::where('date', $date)->get();

        // return $page_title;
        return view('fabric::production.daily_report', compact('page_title', 'productions', 'date'));
    }

    public function getDailyProductionReportPost(Request $request)
    {
        if(isset($request->date)){
            $date = $request->date;
        }else{
            $date = date('Y-m-d');
        }
        $page_title = "Production report of ".$date;

        $productions = Production::with('party', 'knittingprogram', 'knittingprogramDetails', 'productionDetails')->where('date', $date)->get();
        $data = [];
        foreach ($productions as $key => $value) {
                $item = [];
                $item['key'] = $value->id;
                $item['party_name'] = $value->party->name;
                $item['mc_no'] = $value->mc_no;
                $item['mc_dia'] = $value->mc_dia;
                $item['order_quantity'] = $value->order_qty;

            foreach ($value->productionDetails as $result) {
                $item['operator_name'] = $result->employee->name;
                if ($result->shift == 1) {
                    $item['shift'] = 'Day';
                } else {
                    $item['shift'] = 'Night';
                }
                $item['roll'] = $result->roll;
                $item['total_production'] = $result->quantity;
                $item['balance'] = $value->order_qty - $result->quantity;
                $item['rate'] = $result->rate;
                $item['amount'] = $result->quantity * $result->rate;
            }
                array_push($data, $item);
        }
        return response()->json($data);
    }

    public function getWeeklyProductionReport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $date_range = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        foreach ($date_range as $value) {
            $dates[] = $value->format("Y-m-d");
            array_push($dates);
        }

        return view('fabric::production.weekly_report', compact('date_range', 'end_date', 'start_date', 'dates'));
    }

    public function getMonthlyProductionReport(Request $request)
    {
        // Set month and Set year
        $years = $request->year;
        $months = $request->month;
        if(isset($request->month) && isset($request->year)){
            if($request->month ){
                $currentDate = $request->year."-".$request->month;
            }else{
                $currentDate = $request->year."-".$request->month;
            }
        }else{
            $currentDate = date('Y-m-d');
        }

        $formdate=Carbon::parse($currentDate);
        $dates = [];
        for($i=1; $i <$formdate->daysInMonth+1; ++$i) {

            $dates[] =Carbon::createFromDate($formdate->year, $formdate->month, $i)->format('Y-m-d');
        }

        $page_title = "Monthly Production report of ".date('F Y', strtotime($currentDate));

        return view('fabric::production.monthly_report', compact('page_title', 'dates', 'months', 'years'));
    }
}
