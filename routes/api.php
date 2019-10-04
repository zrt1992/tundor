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
Route::get('test', 'CategoryController@test');
Route::get('logout', 'AuthController@logout');
Route::post('/user/category/add','UserController@add_user_categories');
Route::get('/user/category/get/{id}','UserController@get_user_categories');
Route::post('/user/profile/update','UserController@profile_update');
Route::get('/user/profile','UserController@profile');
Route::get('/user/relatedusers','UserController@related_users');

Route::resource('categories', 'CategoryController');

