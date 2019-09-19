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

Route::resource('tasks','TaskController');

//Route::group(['middleware' => 'zulfi:editor'], function ($id) {
//
Route::get('/test', 'TaskController@index');
//});
//
//Route::get('/zulfi', ['middleware' => 'zulfi:editor', function ($id) {
//    dd('asd');
//}]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index')->name('admin');

Route::prefix('admin')->group(function (){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('login-admin');
    Route::get('/dashboard', 'AdminController@index')->name('admin');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
