<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace'=>'Api'],function(){
    Route::any('/send','ApiController@send');
    Route::any('/check','ApiController@checkMessage');
    Route::any('/add','ApiController@saveBuy');
    Route::any('/get','ApiController@get');
    Route::any('/qiniuImg','ApiController@qiniuImg');
    Route::any('/config','ApiController@config');
});
