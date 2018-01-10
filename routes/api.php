<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/migrate', 'AjaxController@migrate_app');

Route::get('/beat-info/{id}', 'TransactionController@get_beat_info');
Route::get('/get-beat', 'TransactionController@get_beat');
Route::post( '/rates', 'RateController@store' );

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {


});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {

    Route::post('/transaction/state', 'TransactionController@tm_transaction_state');
    Route::post('/transaction/new', 'TransactionController@tm_transaction');

//    Route::resource('categories', 'Admin\CategoryController', ['except' => ['create', 'show', 'edit', 'destroy']]);
    Route::get('beats', 'Admin\BeatController@api_beats_json');
    Route::get('instance/{state}', 'Admin\ShopOptionController@instance_state');

});
