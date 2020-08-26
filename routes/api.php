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
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('messages', 'MessageController@index');
    Route::get('messages/{message}', 'MessageController@show');
    Route::post('messages', 'MessageController@store');
});

//register
Route::post('register', 'Auth\RegisterController@register');
//login
Route::post('login', 'Auth\LoginController@login');
//logout 
Route::middleware('auth:api')->post('logout', 'Auth\LoginController@logout');