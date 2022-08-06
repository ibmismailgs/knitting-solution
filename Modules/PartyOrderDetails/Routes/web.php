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

Route::prefix('party-order')->group(function () {
    Route::get('/', 'PartyOrderDetailsController@index');
    Route::group(['middleware' => ['auth', 'role:super-admin|store']], function () {
        Route::any('party-order-list/{id}', 'PartyOrderDetailsController@orderlist')->name('order_list');
        Route::any('party-order-details/{id}', 'PartyOrderDetailsController@orderdetails')->name('orderdetails');

        Route::any('fabric-delivery-details/{id}', 'PartyOrderDetailsController@fabricdetails')->name('fabricdetails');

        Route::any('closeproduction/store', 'PartyOrderDetailsController@closeproduction')->name('closeproduction.store');

    });
});
