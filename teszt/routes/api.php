<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('App\Http\Controllers')->prefix('v1')->group(function () {
    Route::get('teszt',function(){
        return 'okay';
    });
    Route::post('create','UserController@create');
    Route::delete('delete/{user}','UserController@delete');
    Route::put('update/{user}','UserController@update');
});
