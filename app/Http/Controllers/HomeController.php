<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Yarn\Entities\Employee;
use Modules\Yarn\Entities\Party;
use Modules\Account\Entities\Bill;
use Modules\Yarn\Entities\Stock;
use Modules\Yarn\Entities\YarnKnittingDetails;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;
use Carbon\Carbon;

use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_date = Carbon::now('Asia/Dhaka');
        $employees = Employee::all();
        $parties = Party::all();
        $bills  = Bill::where('is_paid',0)->get()->sum('amount');
        $current_balance=Bill::where('is_paid',1)->get()->sum('received_amount');
        $total_yarn=Bill::where('is_paid',1)->get()->sum('received_amount');

        $yarn_stockin=Stock::get()->sum('stock_in');
        $yarn_stockout=Stock::get()->sum('stock_out');
        $yarn_stock=$yarn_stockin-$yarn_stockout;

        $total_received_yarn = ReceiveYarn::get()->sum('quantity');
        // $total_received_yarn = ReceiveYarn::where('date',$current_date->format('Y-m'))->get()->sum('quantity');
        $total_knitting = YarnKnittingDetails::get()->sum('knitting_qty');
        $fab_produced = KnittingProductionDetail::get()->sum('quantity');
        $fab_delivered = KnittingProductionDetail::get()->sum('delivery_quantity');
        $fab_stock=$fab_produced-$fab_delivered;

        $current_yarn_return = YarnKnittingDetails::get()->sum('return_quantity');

        $current_yarn_stock = $total_knitting - ($fab_produced + $current_yarn_return);
        // dd($current_yarn_return);

        return view('pages.admin.dashboard',compact('employees','parties','bills','current_balance','yarn_stock','fab_stock', 'total_received_yarn','total_knitting', 'fab_produced', 'current_yarn_stock'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sample_table()
    {
        return view('pages.admin.sample.table');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sample_form()
    {
        return view('pages.admin.sample.form');
    }
}
