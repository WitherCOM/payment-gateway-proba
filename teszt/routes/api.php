<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Phone;

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
    Route::get('user','UserController@read');
    Route::post('user','UserController@create');
    Route::delete('user/{user}','UserController@delete');
    Route::put('user/{user}','UserController@update');
    Route::get('teszt',function(){
        $users = Phone::all();
        return $users;
    });
});
