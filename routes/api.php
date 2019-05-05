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


Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::get('test', function () {
    return response()->json(['foo' => 'bar']);
});
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('logout', 'AuthController@logout');

});

//Route::group(['prefix' => 'v1'], function () {
//    Route::get('/test', 'AuthController@test');
//});

Route::group(['prefix' => 'v1'], function () {
    Route::get('test', 'AuthController@test');

});