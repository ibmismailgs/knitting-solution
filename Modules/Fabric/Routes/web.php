<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('fabric')->group(function() {
    Route::get('/', 'FabricController@index');
    //Get stl no...
    Route::get('get-party-stl-no', 'FabricController@getPartyStlNo')->name('party-stl-no.get');

    Route::group(['middleware' => ['auth','role:super-admin|store|Accounts']], function() {
        Route::resource('fabric_receive', FabricReceiveController::class);
        Route::resource('fabric_delivery', FabricDeliveryController::class);
        Route::resource('production', ProductionController::class);

        Route::any('party_info', 'FabricDeliveryController@getPartyInfo')->name('party_info');
        Route::any('party_knitting_info', 'FabricDeliveryController@getPartyKnittingInfo')->name('party_knitting_info');
        Route::any('get-yarn-knitting-details', 'FabricDeliveryController@getYarnKnittingDetails')->name('get-yarn-knitting-details');
        Route::any('fab-rec-details/{id}/delete', 'FabricReceiveController@deleteFabricReceiveDetails')->name('fab_rec_details.destroy');

        Route::any('fabric_delivery/{id}/delivery_challan', 'FabricDeliveryController@fabricDeliveryDeliveryChallan')->name('fabric_receive.delivery_challan');
        Route::any('fabric_delivery/{id}/gate_pass', 'FabricDeliveryController@fabricDeliveryGatePass')->name('fabric_receive.gate_pass');

        // Fabric delivery from Production Started ...............
        Route::any('fabric-delivery/production/create', 'FabricDeliveryController@createFabricDeliveryFromProduction')->name('fabric_delivery.prod.create');
        Route::any('fabric-delivery/production/index', 'FabricDeliveryController@getFabricDeliveryListFromProduction')->name('fabric_delivery.prod.index');
        Route::any('fabric-delivery/production/store', 'FabricDeliveryController@storeFabricDeliveryFromProduction')->name('fabric_delivery.prod.store');
        Route::any('fabric-delivery/production/{id}/show', 'FabricDeliveryController@showFabricDeliveryFromProduction')->name('fabric_delivery.prod.show');
        Route::any('fabric-delivery/production/{id}/edit', 'FabricDeliveryController@editFabricDeliveryFromProduction')->name('fabric_delivery.prod.edit');

        Route::any('fabric-delivery/production/{id}/gate_pass', 'FabricDeliveryController@gatePassFabricDeliveryProduction')->name('fabric_delivery.prod.gatePass');
        Route::any('fabric-delivery/production/{id}/bill', 'FabricDeliveryController@billFabricDeliveryProduction')->name('fabric_delivery.prod.bill');
        Route::any('fabric-delivery/production/{id}/delivery_challan', 'FabricDeliveryController@deliveryChallanFabricDeliveryProduction')->name('fabric_delivery.prod.challan');

        Route::any('fabric-delivery/production/{id}/update', 'FabricDeliveryController@UpdateFabricDeliveryFromProduction')->name('fabric_delivery.prod.update');
        Route::any('fabric-delivery/production/{id}/deletea', 'FabricDeliveryController@deleteFabricDeliveryFromProduction')->name('fabric_delivery.prod.delete');


        // Stocks routes..
        Route::any('fabric_stock', 'FabricStockController@getFabricStock')->name('fabric_stock.get');
        Route::any('fabric_stock_details/{id}', 'FabricStockController@getFabricStockDetails')->name('fabric_stock.details');

        Route::any('fabric_stock_production', 'FabricStockController@getProductionFabricStock')->name('fabric_stock_production.get');
        Route::any('fabric_stock_production_details/{id}', 'FabricStockController@getProductionFabricStockDetails')->name('fabric_stock_production.details');

        // Ajax routes.......
        Route::any('get-fab-rec-details', 'FabricDeliveryController@getFabricReceiveDetails')->name('fabric_receive_details');
        Route::any('get-knitting-details', 'FabricDeliveryController@getKnittingDetails')->name('fabric_knitting_details');
        Route::any('get-knitting-production-amount', 'ProductionController@getKnittingProductionAmount')->name('knitting_production_amount');
        Route::any('get-knitting-program', 'ProductionController@getKnittingProgram')->name('get-knitting-program');
        Route::any('get-knitting-program_details', 'ProductionController@getKnittingProgramDetails')->name('get-knitting-program-details');

        // Production reports.....
        Route::any('daily_production', 'ProductionController@getDailyProductionReportGet')->name('daily.daily_production');
        Route::any('daily_production_report', 'ProductionController@getDailyProductionReportPost')->name('daily.production_report');
        Route::any('weekly_production_report', 'ProductionController@getWeeklyProductionReport')->name('weekly.production_report');
        Route::any('monthly_production_report', 'ProductionController@getMonthlyProductionReport')->name('monthly.production_report');

    });

});
