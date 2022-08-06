<?php

use Modules\Yarn\Entities\Stock;
use Modules\Yarn\Entities\Party;
use Modules\Yarn\Entities\ReceiveYarn;
use Modules\Fabric\Entities\Production;
use Modules\Yarn\Entities\YarnKnittingDetails;

//Get payment type
if (! function_exists('getPaymentType')) {
    function getPaymentType($type) {
        if($type == 1){
            return "Cash";
        }
        if($type == 2){
            return "Cheque";
        }
        if($type == 3){
            return "LC";
        }

    }
}

//Get party info
if (! function_exists('getPartyInfo')) {
    function getPartyInfo($party_id) {
        $party = Party::find($party_id);
        return $party;
    }
}

//Get Receive Yarn info
if (! function_exists('getReceiveYarnInfo')) {
    function getReceiveYarnInfo($rec_id) {
        $rec_yarn = ReceiveYarn::find($rec_id);
        return $rec_yarn;
    }
}

//Get party wise Yarn stock
if (! function_exists('getStock')) {
    function getStock($party_id, $receive_id) {
        $stock_in = Stock::where('party_id', $party_id)->where('receive_id', $receive_id)->sum('stock_in');
        $stock_out = Stock::where('party_id', $party_id)->where('receive_id', $receive_id)->sum('stock_out');
        $stock = $stock_in - $stock_out;

        return $stock;
    }
}

//Get party wise Fabric stock from Receive
if (! function_exists('getFabricStock')) {
    function getFabricStock($receive_id, $party_id) {
        $stock_in = DB::table('fabric_stocks')->where('party_id', $party_id)->where('receive_id', $receive_id)->sum('stock_in');
        $stock_out = DB::table('fabric_stocks')->where('party_id', $party_id)->where('receive_id', $receive_id)->sum('stock_out');
        $stock = $stock_in - $stock_out;

        return $stock;
    }
}

//Get party wise Fabric stock from Production
if (! function_exists('getProductionFabricStock')) {
    function getProductionFabricStock($production_id, $party_id, $knitting_id) {
        $stock_in = DB::table('knitting_production_details')->where('party_id', $party_id)->where('production_id', $production_id)
                    ->where('knitting_id', $knitting_id)->sum('quantity');

        $stock_out = DB::table('knitting_production_details')->where('knitting_id', $knitting_id)
                        ->sum('delivery_quantity');

        $stock = $stock_in - $stock_out;

        return $stock;
    }
}

//Get stl wise knitting qty
if (! function_exists('getTotalKnittingQty')) {
    function getTotalKnittingQty($knitting_id) {
        $knittingTotal = YarnKnittingDetails::where('knitting_id', $knitting_id)->sum('knitting_qty');
        return $knittingTotal;
    }
}

//Get daily total order quantity
if (! function_exists('getDailyOrderQuantity')) {
    function getDailyOrderQuantity($date) {
        // $productions = Production::where('date', $date)->select('date', DB::raw('sum(order_qty) as total_order'), DB::raw('sum(roll) as total_roll'),
        // DB::raw('sum(quantity) as total_kg'), DB::raw('sum(kg) as total_production'), DB::raw('sum(amount) as total_amount'))
        // ->groupBy('date')->first();

        $order_qty = Production::where('date', $date)->sum('order_qty');
        return $order_qty;
    }
}

//Get daily total roll quantity
if (! function_exists('getDailyRoll')) {
    function getDailyRoll($date) {

        $roll = DB::table('productions')
            ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
            ->where('productions.date', $date)
            ->sum('knitting_production_details.roll');

        // $roll = Production::where('date', $date)->sum('roll');
        return $roll;
    }
}

//Get daily total kg
if (! function_exists('getDailyKg')) {
    function getDailyKg($date) {
        $kg = DB::table('productions')
        ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
        ->where('productions.date', $date)
        ->sum('knitting_production_details.quantity');
        // $kg = Production::where('date', $date)->sum('quantity');
        return $kg;
    }
}

//Get daily total prod amount
if (! function_exists('getDailyTotalProduction')) {
    function getDailyTotalProduction($date) {
        $qty = DB::table('productions')
            ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
            ->where('productions.date', $date)
            ->sum('knitting_production_details.quantity');
        // $qty = Production::where('date', $date)->sum('quantity');

        return $qty;
    }
}

//Get daily total prod amount
if (! function_exists('getDailyAmount')) {
    function getDailyAmount($date) {
        $amount = DB::table('productions')
            ->join('knitting_production_details', 'knitting_production_details.production_id', '=', 'productions.id')
            ->where('productions.date', $date)
            ->sum('knitting_production_details.amount');
        // $amount = Production::where('date', $date)->sum('amount');
        return $amount;
    }
}
