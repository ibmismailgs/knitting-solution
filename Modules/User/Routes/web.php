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

Route::prefix('user')->group(function() {
    // Route::get('/', 'Modules\User\Entities\UserController@index');

    Route::group(['middleware' => ['auth']], function() {
        Route::group(['middleware' => ['role:super-admin|data-entry','permission:role-list|role-create|role-edit|role-delete']], function () {
            Route::resource('roles', RoleController::class);
        });
        
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::get('user-profile', 'UserController@profile')->name('user.profile');
    });
});
