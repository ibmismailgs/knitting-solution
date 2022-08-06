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

Route::prefix('yarn')->group(function() {
    Route::get('/', 'YarnController@index');

    Route::group(['middleware' => ['auth','role:super-admin']], function() {
        Route::resource('party', PartyController::class);
    });
    Route::group(['middleware' => ['auth', 'role:super-admin|store|Accounts']], function() {
        Route::resource('receive_yarn', ReceiveYarnController::class);

        Route::post('return_yarn/storeYern','ReturnYarnController@storeYearn')->name('return_yarn.storeYearn');
        Route::resource('return_yarn', ReturnYarnController::class);
        Route::resource('knitting', KnittingProgramController::class);
        // Route::resource('customer', CustomerController::class);



        Route::get('return_yarn/{id}/challan','ReturnYarnController@deliveryChallanReturnYarn')->name('return_yarn.delivery_challan');
        Route::get('return_yarn/{id}/gate_pass','ReturnYarnController@gatePassReturnYarn')->name('return_yarn.gate_pass');

        //Ajax routes..........
        Route::any('party_info', 'PartyController@getPartyInfo')->name('party_info');
        Route::any('party_info/edit', 'PartyController@getPartyInfoEdit')->name('party_info_edit');

        // Knitting routes
        Route::any('knitting_details/{id}/edit', 'KnittingProgramController@editKnittingDetails')->name('knitting_details.edit');
        Route::any('knitting_details/{id}/update', 'KnittingProgramController@updateKnittingDetails')->name('knitting_details.update');
        Route::any('knitting_details/{id}/delete', 'KnittingProgramController@deleteKnittingDetails')->name('knitting_details.destroy');


        Route::any('add-more/{id}', 'KnittingProgramController@addMoreKnitting')->name('knitting.add_more');
        Route::any('update-more-qty/{id}', 'KnittingProgramController@submitMoreKnittingQty')->name('knitting-program.add-more-qty');


        Route::any('party_wise_yarn_info', 'KnittingProgramController@getPartyYarnReceiveInfo')->name('party_yarn_info');
        Route::any('receive_wise_yarn_stock', 'KnittingProgramController@getStockInfo')->name('receive_wise_yarn_stock');

        Route::any('rec_yarn_info', 'PartyController@getRecYarnInfo')->name('rec_yarn_info');
        Route::any('rec_yarn_info/edit', 'PartyController@getRecYarnInfoEdit')->name('rec_yarn_info.edit');

        Route::any('yarn_stock', 'YarnController@stock')->name('yarn_stock.index');
        Route::any('yarn_stock_details/{id}', 'YarnController@stockDetails')->name('yarn_stock.show');
    });
});
Route::group(['middleware' => ['auth','role:super-admin|store']], function() {
    Route::resource('employee', EmployeeController::class);
});
