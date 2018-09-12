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
// 1.0版本
Route::group(['namespace'=>'Api'],function(){
    Route::any('/send','ApiController@send');
    Route::any('/check','ApiController@checkMessage');
    Route::any('/add','ApiController@saveBuy');
    Route::any('/get','ApiController@get');
    Route::any('/qiniuImg','ApiController@qiniuImg');
    Route::any('/qiniuImgBack','ApiController@qiniuImgBack');
    Route::any('/wechatImg','ApiController@wechatImg');
    Route::any('/config','ApiController@config');
    Route::any('/IndexConfig','ApiController@indexConfig');
    Route::any('/sendAgain','ApiController@sendAgain');
    Route::any('/sendMessageAli','ApiController@sendMessageAli');
    Route::any('/idCard','ApiController@idCard');
    Route::any('/qiniuTest','ApiController@qiniuTest');
    Route::any('/result','ApiController@result');
    Route::any('/getImg','ApiController@getImg');
    Route::any('/loginDirect','ApiController@loginDirect');
});

// 2.0版本
Route::group(['namespace'=>'Api'],function(){
    Route::any('/getUserInfo','ApiWechatController@getUserInfo');
    Route::any('/getfloor','ApiWechatController@floorConfig');
    Route::any('/addBook','ApiWechatController@addBook');
    Route::any('/cancelBook','ApiWechatController@cancelBook');
    Route::any('/saleCode','ApiWechatController@saleCode');
    Route::any('/addSale','ApiWechatController@addSale');
    Route::any('/getlist','ApiWechatController@appointmentList');
    Route::any('/saleType','ApiWechatController@saleType');
    Route::any('/isAddSale','ApiWechatController@isAddSale');
    Route::any('/visitList','ApiWechatController@visitList');
    Route::any('/extensionList','ApiWechatController@extensionList');
    Route::any('/balanceList','ApiWechatController@balanceList');
});