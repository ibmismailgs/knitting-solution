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

Route::prefix('account')->group(function() {
    Route::get('/', 'AccountController@index');

    Route::group(['middleware' => ['auth', 'role:super-admin|store|Accounts']], function() {

        Route::resource('bill', BillController::class);
        Route::any('bill-due', 'BillController@dueBillCreate')->name('bill-due.create');
        Route::any('bill-due/store', 'BillController@dueBillStore')->name('bill-due.store');
        Route::any('bill-due/index', 'BillController@dueBillindex')->name('bill-due.index');
        Route::get('bill_ledger', 'BillController@getBillLedger')->name('bill.ledger');
        Route::get('bill_ledger_details/{id}', 'BillController@getBillLedgerDetails')->name('bill.ledger.details');

        Route::resource('delivery-bill', DeliveryBillController::class);
        Route::resource('revenue', RevenueController::class);
        Route::resource('expense', ExpenseController::class);


        // Ajax routes............
        Route::any('get-bill-amount', 'BillController@getBillAmount');
        Route::any('get-challan', 'DeliveryBillController@getDeliveryChallanInfo');
        Route::any('get-challan-details', 'DeliveryBillController@getChallanDetails');
    });
});
