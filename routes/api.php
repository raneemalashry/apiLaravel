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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register','Api\UserController@register');
Route::post('login','Api\UserController@login');

 Route::group(['middleware'=>'auth:api'], function(){
    Route::get('users/index','Api\UserController@index');
    Route::post('users/update','Api\UserController@update');
    Route::post('users/delete','Api\UserController@destroy');
   
});



