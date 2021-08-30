<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace'=>'Api'], function(){

    Route::get('/register', 'UserController@create');
    Route::post('register', 'UserController@store');
});

Route::get('/login','LoginController@showLogin')->name('login');
Route::post('/login','LoginController@login');
Route::group(['middleware'=>'auth'],function(){
    Route::get('/home','LoginController@home');
    Route::post('logout', 'LoginController@logout')->name('logout');
});
