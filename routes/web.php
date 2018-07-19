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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', function () {
    return view('Back.login');
});


Route::group(['namespace'=>'Back'],function(){
    Route::any('/loginCheck', "loginController@check");
    Route::any('/loginout', "loginController@loginout");
});


Route::group(['prefix'=>'admin','namespace'=>'Back','middleware'=>'admin'],function(){
    Route::any('/index', "IndexController@index");
    Route::any('/buy/read/{id}/{type}', "IndexController@read");
    Route::any('/buy/readRandom/{type}', "IndexController@readRandom");
    Route::any('/buy/img/{id}/{type}', "IndexController@img");
    Route::any('/buy/disagreement', "IndexController@disagreement");
    Route::any('/buy/status', "IndexController@status");
    Route::any('/buy/excel/{type}', "IndexController@excel");
    Route::any('/buy/latestStatus', "IndexController@latestStatus");
    Route::any('/back/edit', "IndexController@userEdit");
    Route::any('/back/file', "IndexController@file");
    Route::any('/send', "IndexController@send");
    Route::any('/list', "AdminController@index");
    Route::any('/read/{id}', "AdminController@read");
    Route::any('/save', "AdminController@save");
    Route::any('/del', "AdminController@del");
    Route::any('/config', "ConfigController@index");
    Route::any('/config/save', "ConfigController@save");
    Route::any('/user/list/{id}', "UserListController@index");
});


